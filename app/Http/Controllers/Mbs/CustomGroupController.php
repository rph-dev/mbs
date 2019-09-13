<?php

namespace App\Http\Controllers\Mbs;


use App\Http\Controllers\Controller;
use App\Models\Mbs\MbsContactGroupCustom;
use App\Models\Mbs\MbsGroup;
use App\Models\Mbs\MbsMessageList;
use App\Models\Mbs\MbsUserCustom;
use App\Models\User\Department;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

/**
 * Class CustomGroupController
 * @package App\Http\Controllers\Modules\mbs
 */
class CustomGroupController extends Controller
{

    /**
     * Display a listing of the Division.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $model = MbsContactGroupCustom::paginate(50);

        return view('mbs.custom_group.index', compact('model'));
    }

    /**
     * @return array
     */
    public function groupTypeList(){

        $departments = Department::getDepartmentList();

        $groupCustom = MbsContactGroupCustom::get(['name', 'id'])->toArray();

        $users = User::userActive()->get(['name', 'id'])->toArray();

        $userCustom = MbsUserCustom::get(['name', 'id'])->toArray();

        $departmentList = [];
        foreach ($departments as $k => $v){
            $departmentList['d'.$k] = $v;
        }

        $groupCustomList = [];
        foreach ($groupCustom as $k => $v){
            $groupCustomList['g'.$v['id']] = $v['name'];
        }

        $usersList = [];
        foreach ($users as $k => $v){
            $usersList['u'.$v['id']] = $v['name'];
        }

        $usersCustomList = [];
        foreach ($userCustom as $k => $v){
            $usersCustomList['c'.$v['id']] = $v['name'];
        }

        $contacts = [
            'แผนก/ฝ่าย' => $departmentList,
            'กลุ่มอื่น ๆ' => $groupCustomList,
            'ผู้ใช้งาน' => $usersList,
            'ผู้ใช้งานพิเศษ' => $usersCustomList
        ];

        return $contacts;
    }

    /**
     * @param $model MbsContactGroupCustom
     * @return mixed MbsContactGroupCustom
     */
    protected function loadForm($model){

        $contacts = $this->groupTypeList();

        $model->setAttribute('contact_type_id', $contacts);

        return $model;
    }

    /**
     * Show the form for creating a new Division.
     *
     * @return Response
     */
    public function create()
    {
        $model = new MbsContactGroupCustom();

        $model = $this->loadForm($model);

        return view('mbs.custom_group.create', compact('model'));
    }

    /**
     * Store a newly created Division in storage.
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name'=>'required|max:255',
            'contact_type_id' => 'required'
        ]);

        $input = $request->all();

        $model = MbsContactGroupCustom::create($input);

        if(!empty($model->id)){

            $now = Carbon::now();
            $groupCustomUserList = [];
            foreach ($input['contact_type_id'] as $value) {
                $groupCustomUserList[] = [
                    'custom_group_id' =>  $model->id,
                    'contact_id' => $value,
                    'created_at' => $now
                ];
            }

            $model->groupCustomUserList()->insert($groupCustomUserList);
        }

        return redirect(route('mbs.group-custom.index'))
            ->with('success', 'Created Division: Success!');
    }

    /**
     * Display the specified Division.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect(route('mbs.group-custom.edit', compact('id')));
    }

    /**
     * Show the form for editing the specified Division.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $model = MbsContactGroupCustom::with(['groupCustomUserList'])->findOrFail($id);

        $model = $this->loadForm($model);

        $model->setAttribute('groupCustomUserList', $model->groupCustomUserList->pluck('contact_id'));

        return view('mbs.custom_group.edit', compact('model'));
    }

    /**
     * Update the specified Division in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'contact_type_id' => 'required'
        ]);

        $model = MbsContactGroupCustom::findOrFail($id);

        $input = $request->all();

        $model->fill($input);

        $model->save();

        if(!empty($model->id)){

            $now = Carbon::now();
            $groupCustomUserList = [];
            foreach ($input['contact_type_id'] as $value) {
                $groupCustomUserList[] = [
                    'custom_group_id' => $model->id,
                    'contact_id' => $value,
                    'created_at' => $now
                ];
            }

            $model->groupCustomUserList()->where('custom_group_id', $model->id)->forceDelete();
            $model->groupCustomUserList()->insert($groupCustomUserList);
        }

        return redirect(route('mbs.group-custom.edit', compact('id')))
            ->with('success', 'Updated Division: Success!');
    }

    /**
     * Remove the specified Division from storage.
     *
     * @param int $id
     *
     * @return array|Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = MbsContactGroupCustom::findOrFail($id);

        $model->delete();

        $model->groupCustomUserList()->where('custom_group_id', $id)->forceDelete();

        $contactId = "g{$id}";

        $groupIdList = MbsGroup::where('contact_id', $contactId)->where('total', 1)->pluck('group_id')->toArray();
        if(count($groupIdList)){
            MbsMessageList::whereIn('group_id', $groupIdList)->delete();
        }

        $groupIdList = MbsGroup::where('contact_id', $contactId)->pluck('group_id')->toArray();
        MbsGroup::whereIn('group_id', $groupIdList)->decrement('total', 1);
        MbsGroup::where('contact_id', $contactId)->delete();

        return [
            'success' => true,
            'data'    => $id,
            'message' => 'User Group deleted successfully'
        ];
    }
}
