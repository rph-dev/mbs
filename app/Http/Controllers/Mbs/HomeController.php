<?php

namespace App\Http\Controllers\Mbs;

use App\Http\Controllers\API\LineBot\LineBotController;
use App\Http\Controllers\Controller;
use App\Models\Mbs\MbsContactGroupCustom;
use App\Models\Mbs\MbsContactGroupCustomUserList;
use App\Models\Mbs\MbsGroup;
use App\Models\Mbs\MbsMessage;
use App\Models\Mbs\MbsMessageFiles;
use App\Models\Mbs\MbsMessageList;
use App\Models\Mbs\MbsUserCustom;
use App\Models\User\Department;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers\Mbs
 */
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        return view('mbs.home.index');
    }

    /**
     * @param $groupId
     * @return \Illuminate\Support\Collection
     */
    public function fetchGroupList($groupId){
        $groupList = MbsGroup::where('group_id', $groupId)
            ->selectRaw('contact_id as contact_type_id')
            ->pluck('contact_type_id');

        return $groupList;
    }

    /**
     * @param $groupId
     * @return MbsMessageList[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function fetchMessage($groupId){
        $messageList = MbsMessageList::with(['message' => function($q){
            $q->with(['files', 'userProfile' => function($q) {
                $q->with('department')->exclude(['birth_date', 'password']);
            }]);
        }])->where('group_id', $groupId)->groupBy('message_id')->get();

        return $messageList;
    }

    /**
     * @param $contactTypeIdList
     * @return array
     */
    private function checkContactGroup($contactTypeIdList){

        $totalContactList = count($contactTypeIdList);
        $userProfile = Auth::user();

        $contactTypeList = MbsGroup::where([
            'user_id' => $userProfile->id,
            'position_id' => $userProfile->position_id,
            'department_id' => $userProfile->department_id
        ]);

        foreach ($contactTypeIdList as $contact){
            $contactTypeList->where('contact_id', $contact);
        }

        $contactTypeList = $contactTypeList->where('total', $totalContactList)
            ->groupBy('group_id')->first('group_id');

        $messageList = null;
        $groupList = null;

        if($contactTypeList){
            $totalGroupList = MbsGroup::selectRaw('count(0) as total')->where('group_id', $contactTypeList->group_id)->first();

            if((int)$totalGroupList->total === $totalContactList){
                $messageList = $this->fetchMessage($contactTypeList->group_id);
                $groupList = $this->fetchGroupList($contactTypeList->group_id);
            }
        }

        return compact('messageList', 'groupList');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function loadContact(Request $request){
        $contactTypeIdList = $request->get('contact_id');

        $contact = $this->checkContactGroup($contactTypeIdList);

        return [
            'message_list' => $contact['messageList'] ?? null,
            'group_list' => $contact['groupList'] ?? null
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function loadMessage(Request $request){

        $groupId = $request->get('group_id');

        $messageList = $this->fetchMessage($groupId);

        $groupList = $this->fetchGroupList($groupId);

        return [
            'message_list' => $messageList,
            'group_list' => $groupList
        ];
    }

    /**
     * @return array
     */
    public function initHistoryContact() {

        $userProfile = Auth::user();

        $historyContactList = MbsMessageList::with('group')
            ->select('group_id')
            ->where([
                'user_id' => $userProfile->id,
                'position_id' => $userProfile->position_id,
                'department_id' => $userProfile->department_id
            ])
            ->groupBy('group_id')->orderByDesc('id')->get();

        return [
            'history_contact_list' => $historyContactList,
        ];
    }

    /**
     * @return array
     */
    public function initContact() {

        $departments = Department::getDepartmentList();

        $groupCustom = MbsContactGroupCustom::get(['name', 'id'])->toArray();;

        $users = User::userActive()->get(['name', 'id'])->toArray();

        $userCustom = MbsUserCustom::get(['name', 'id'])->toArray();

        $contacts = [
            [
                'group_name' => 'ทั้งหมด',
                'data' => [
                    [
                        'key' => 'all',
                        'value' => 'ฝ่าย/แผนก ทั้งหมด'
                    ]
                ]
            ]
        ];

        $departmentList = [];
        foreach ($departments as $k => $v){
            $departmentList[] = [
                'key' => 'd'.$k,
                'value' => $v
            ];
        }
        $contacts[] = [
            'group_name' => "ฝ่าย",
            'data' => $departmentList
        ];

        $groupCustomList = [];
        foreach ($groupCustom as $k => $v){
            $groupCustomList[] = [
                'key' => 'g'.$v['id'],
                'value' => $v['name']
            ];
        }

        $contacts[] = [
            'group_name' => 'กลุ่มอื่น ๆ',
            'data' => $groupCustomList
        ];

        $usersList = [];
        foreach ($users as $k => $v){
            $usersList[] = [
                'key' => 'u'.$v['id'],
                'value' => $v['name']
            ];
        }

        $contacts[] = [
            'group_name' => 'ผู้ใช้งาน',
            'data' => $usersList
        ];

        $usersList = [];
        foreach ($userCustom as $k => $v){
            $usersList[] = [
                'key' => 'c'.$v['id'],
                'value' => $v['name']
            ];
        }

        $contacts[] = [
            'group_name' => 'ผู้ใช้งานพิเศษ',
            'data' => $usersList
        ];

        return $contacts;
    }

    /**
     * Store a newly created MBS in storage.
     *
     * @param Request $request
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){

        // faker id
        $fakerMessageId = time();

        if($request->post('message_type') === 'image'){
            // Image
            $this->validate($request, [
                'contact_id' => 'required',
                'mbs_files.*' => 'required|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
        }else if($request->post('message_type') === 'video'){
            // Video
            $this->validate($request, [
                'contact_id' => 'required',
                'mbs_files.*' => 'required|mimes:mp4,qt,mov,avi|max:100000'
            ]);
        }else{
            // Text
            $this->validate($request, [
                'title'=>'required|max:255',
                'detail' => 'required',
                'contact_id' => 'required',
                'mbs_files.*' => 'mimes:jpeg,png,jpg,gif,doc,docx,xls,xlsx,ppt,pptx,pdf|max:4048'
            ]);
        }

        $input = $request->only(['title', 'detail']);
        $input['type'] = $request->post('message_type');

        /*
         * 1. check upload has file
         * 2. upload success
         * 3. send message
         */
        // upload file
        if ($request->hasFile('mbs_files')){
            $this->filesUpload($request->file('mbs_files'), $fakerMessageId);
        }

        $contactIdList = explode(',', $request->post('contact_id'));

        $messageList = [];
        $groupList = [];

        if($contactIdList){

            $userProfile = Auth::user();

            $input['user_id'] = $userProfile->id;
            $input['position_id'] = $userProfile->position_id;
            $input['department_id'] = $userProfile->department_id;

            $modelMessage = MbsMessage::create($input);

            $contact = $this->checkContactGroup($contactIdList);
            $groupId = $contact['messageList'][0]['group_id'] ?? null;
            $totalContactIdList = count($contactIdList);


            if(empty($contact['groupList'])){
                $groupId = time();
                $now = Carbon::now();
                $mbsGroupArr = [];

                foreach ($contactIdList as $contact){
                    $mbsGroupArr[] = [
                        'group_id' => $groupId,
                        'contact_id' => $contact,
                        'total' => $totalContactIdList,
                        'user_id' => $userProfile->id,
                        'position_id' => $userProfile->position_id,
                        'department_id' => $userProfile->department_id,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
                MbsGroup::insert($mbsGroupArr);
            }

            MbsMessageList::create([
                'message_id' => $modelMessage->id,
                'group_id' => $groupId,
                'user_id' => $userProfile->id,
                'position_id' => $userProfile->position_id,
                'department_id' => $userProfile->department_id
            ]);

            // replace file id
            if ($request->hasFile('mbs_files')){
                $this->updateFileMessageId($fakerMessageId, $modelMessage->id);
            }

            // send message
            $this->broadcastMessage($groupId, $modelMessage->id);

            $messageList = $this->fetchMessage($groupId);

            $groupList = $this->fetchGroupList($groupId);
        }

        return [
            'message_list' => $messageList,
            'group_list' => $groupList
        ];

    }

    /**
     * @param $filesInput
     * @param $messageId
     * @return bool
     */
    protected function filesUpload($filesInput, $messageId){

        $files = [];
        foreach($filesInput as $file)
        {
            /*
            //Display File Name
            echo 'File Name: '.$file->getClientOriginalName();
            echo '<br>';

            //Display File Extension
            echo 'File Extension: '.$file->getClientOriginalExtension();
            echo '<br>';

            //Display File Real Path
            echo 'File Real Path: '.$file->getRealPath();
            echo '<br>';

            //Display File Size
            echo 'File Size: '.$file->getSize();
            echo '<br>';

            //Display File Mime Type
            echo 'File Mime Type: '.$file->getMimeType();
            */

            $mimeType = explode('/', $file->getMimeType());
            $uid = uniqid();
            $videoThumbnail = null;

            if($mimeType[0] === 'video') {

                $videoThumbnail = 'video_thumbnail/'.$messageId.'_'.$uid.'.jpg';

                $path = public_path('/storage/mbs/video_thumbnail');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $ffmpeg = \FFMpeg\FFMpeg::create();
                $video = $ffmpeg->open($file->getRealPath());
                $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(10));
                $frame->save(public_path('/storage/mbs/'.$videoThumbnail));
            }

            $filePath = '/storage/mbs/';

            $fileNameNew = $messageId.'_'.$uid.'.'.$file->getClientOriginalExtension();

            $path = public_path($filePath);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $file->move($path, $fileNameNew);
            $now = Carbon::now();

            $files[] = [
                'uid' => $uid,
                'message_id' => $messageId,
                'file_type' => $file->getClientOriginalExtension(),
                'file_name' => $fileNameNew,
                'file_name_old' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'video_thumbnail' => $videoThumbnail,
                'user_id' => Auth::user()->id,
                'created_at'=> $now,
                'updated_at'=> $now
            ];
        }
        // insert data
        return MbsMessageFiles::insert($files);
    }

    /**
     * @param $fakerId
     * @param $messageId
     * @return int
     */
    protected function updateFileMessageId($fakerId, $messageId){
        return MbsMessageFiles::where('message_id', $fakerId)->update(['message_id' => $messageId]);
    }

    /**
     * @param $groupId
     * @param $messageId
     */
    public function broadcastMessage($groupId, $messageId)
    {
        //$messageId
        /*
         * 1. ดูว่ามีผู้ใช้อยู่กลุ่มอะไรบ้าง
         * 2. ดูว่าอยู่ใน user mapping
         * 3. multicast max 150
         */

        $lineIdList = $this->findLineIdList($groupId);
        $message = $this->composeMessage($messageId);

        // send message broadcast
        foreach ($lineIdList as $lindId){
            (new LineBotController)->multicastMessage($lindId, $message);
        }

    }

    /**
     * @param $messageId
     * @return array
     */
    private function composeMessage($messageId){

        $message = MbsMessage::with(['files', 'userProfile' => function($q) {
            $q->with('department')->exclude(['birth_date']);
        }])->find($messageId);

        $msgBy = "โดย: {$message->userProfile->name} ({$message->userProfile->department->name})\n\n";
        $title = $message->title ? "{$message->title}\n" : null;
        $detail = $message->detail ?? null;

        $composeMsg = $title;
        $composeMsg .= $msgBy;
        $composeMsg .= $detail;

        $messages = [];

        $appUrl = config('app.url');

        if($message->type === 'text'){

            if(count($message->files)){
                $composeMsg .= "\nไฟล์ที่แนบ:";
                foreach ($message->files as $file){
                    $composeMsg .= "\n- {$appUrl}{$file->file_path}{$file->file_name}";
                }
            }

        }else if($message->type === 'image'){
            $messages[] = [
                'type' => "image",
                'originalContentUrl' => "{$appUrl}{$message->files[0]->file_path}{$message->files[0]->file_name}",
                'previewImageUrl' => "{$appUrl}{$message->files[0]->file_path}{$message->files[0]->file_name}"
            ];
        }else if($message->type === 'video'){
            $messages[] = [
                'type' => "video",
                'originalContentUrl' => "{$appUrl}{$message->files[0]->file_path}{$message->files[0]->file_name}",
                'previewImageUrl' => "{$appUrl}{$message->files[0]->file_path}{$message->files[0]->video_thumbnail}"
            ];
        }

        $messages[] = [
            'type' => "text",
            'text' => $composeMsg,
        ];


        return $messages;
    }

    /**
     * @param $groupId
     * @return array
     */
    private function findLineIdList($groupId){
        $groupList = \DB::table('v_mbs_group')->where('group_id', $groupId)->get();

        $users = [];
        foreach ($groupList as $group){
            $contactOnlyId = $group->contact_only_id;
            $contactType = $group->contact_type;
            //
            $usersList = $this->listUserByType($contactOnlyId, $contactType);
            if(count($usersList))
                $users = array_merge($users, $usersList);
        }

        // method flattens a multi-dimensional array into a single level array:
        $users = Arr::flatten($users);

        // Removes duplicate values from an array
        $users = array_unique($users);

        // Split an array into chunks
        return array_chunk($users, 150);
    }

    /**
     * @param $contactOnlyId
     * @param $contactType
     * @return array
     */
    private function listUserByType($contactOnlyId, $contactType){

        $users = [];
        // Department
        if($contactType === "d"){
            $users = $this->findUsersByDepartment($contactOnlyId);
        // group
        } else if($contactType === "g"){
            $users = $this->findUsersByCustomGroup($contactOnlyId);
        // users
        } else if($contactType === "u"){
            $users = $this->findUsersByUserId($contactOnlyId);
        // custom group
        } else if($contactType === "c"){
            $users = $this->findUsersByUserCustom($contactOnlyId);
        }

        return $users;
    }

    /**
     * @param $contactOnlyId
     * @return array
     */
    private function findUsersByCustomGroup($contactOnlyId){
        $customGroup = MbsContactGroupCustomUserList::where('custom_group_id', $contactOnlyId)->get();

        $users = [];
        foreach ($customGroup as $group){
            $contactId = substr($group->contact_id, 1);
            $contactType = substr($group->contact_id, 0,1);
            $users[] = $this->listUserByType($contactId, $contactType);
        }

        return $users;
    }

    /**
     * @param $contactOnlyId
     * @return mixed
     */
    private function findUsersByDepartment($contactOnlyId){

        $users = User::whereHas('department', function($q) use($contactOnlyId) {
            $q->where('id', $contactOnlyId);
        });

        return $users->userActive()
            ->join('mbs_users_mapping as map', 'map.user_id', '=', 'users.id')
            ->pluck('map.line_id')->toArray();
    }

    /**
     * @param $contactOnlyId
     * @return mixed
     */
    private function findUsersByUserId($contactOnlyId){
        return User::find($contactOnlyId)
            ->userActive()
            ->join('mbs_users_mapping as map', 'map.user_id', '=', 'users.id')
            ->pluck('map.line_id')->toArray();
    }

    /**
     * @param $contactOnlyId
     * @return array
     */
    private function findUsersByUserCustom($contactOnlyId){
        return MbsUserCustom::find($contactOnlyId)
            ->join('mbs_users_mapping as map', 'map.user_custom', '=', 'mbs_users_custom.id')
            ->pluck('map.line_id')->toArray();
    }
}
