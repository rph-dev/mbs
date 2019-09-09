<?php

namespace App\Http\Controllers\API\LineBot;

use App\Http\Controllers\Controller;
use App\Models\Mbs\MbsUserCustom as UserCustom;
use App\Models\Mbs\MbsUserMapping as UserMapping;
use App\Models\User\User;
use App\Traits\LineApi;
use Illuminate\Support\Carbon;
use function response;

/**
 * Class LineBotController
 * @package App\Http\Controllers\API\LineBot
 */
class LineBotController extends Controller
{

    use LineApi;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $channelAccessToken;
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $channelSecret;

    /**
     * @var \Illuminate\Database\Eloquent\Model|object|static|null
     */
    private $lineUserId;
    /**
     * @var
     */
    private $lineMessage;
    /**
     * @var
     */
    private $lineState;
    /**
     * @var
     */
    private $replyToken;
    /**
     * @var array
     */
    private $lineStateStruct = [
        'join' => null,
        'menu' => null,
        'check' => null,
        'user' => [
            'line_code' => null,
            'birthday' => null
        ]
    ];


    /**
     * LineBotController constructor.
     */
    public function __construct()
    {
        $this->channelAccessToken = config('line-bot.mbs.channel_access_token');
        $this->channelSecret = config('line-bot.mbs.channel_secret');
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function bot()
    {

        $event = $this->parseEvents();
        //\File::put(public_path('lineEvents.text'), json_encode($event, JSON_PRETTY_PRINT));
        //\File::put(public_path('lineEvents2.text'), json_encode(request()->all(), JSON_PRETTY_PRINT));

        //$this->debug($this->getUserMapping($event[0]['source']['userId'], true));
        $this->lineUserId = $event[0]['source']['userId'];
        $this->replyToken = $event[0]['replyToken'];
        $this->lineMessage = $event[0]['message']['text'];
        $this->lineState =  $this->getState();

        if ($this->getUserMapping(true)) {
            $this->listCommand();
        } else {
            // insert line id
            UserMapping::firstOrCreate(['line_id' => $this->lineUserId]);

            //$this->debug($this->lineState['join']);
            if (in_array($this->lineMessage, ['join']) || (empty($this->lineState['join']) && in_array($this->lineMessage, ['1'])) || (($this->lineState['join']))) {
                //$this->debug('xx');
                $this->joinRPH();
            } else {
                $this->listCommand(false);
            }
        }

        return response('ok', 200);
    }

    /**
     * @param $this ->lineUserId
     */
    private function joinRPH()
    {
        /*
         * กดหมายเลขเพื่อเลือกประเภทการเชื่อมต่อ
            1 แบบพนักงาน
                1.1 กรอก Code
                1.2 กรอกวันเดือนปีเกิดของท่าน (ตัวอย่าง 01102533)
            2 แบบหน่วยงานอื่น ๆ (ไม่ใช่พนักงาน)
                2.1 กรอกรหัส 6 หลักที่ได้รับ

            เมื่อเชื่อมต่อสำเร็จ
            - แสดงข้อความการเชื่อมต่อสำเร็จยินดีต้อนรับเข้าสู่ระบบ MBS

            เมื่อเชื่อมต่อไม่สำเร็จ
            - แสดงข้อความการเชื่อมต่อไม่สำเร็จ
            - แสดงข้อความ เริ่มต้นขั้นตอนใหม่หมด
         */
        if (empty($this->lineState['join']) || $this->lineMessage === '0') {

            $messageCompose = "พิมพ์หมายเลข เพื่อเลือกประเภทการเชื่อมต่อ\n[1] แบบพนักงาน\n[2] แบบบุคคลหรือหน่วยงานอื่น ๆ\n";
            $messageCompose .= "\n-----------------------\nพิมพ์ x เพื่อกลับเมนูหลัก";
            $this->lineState = $this->lineStateStruct;
            $this->lineState['join'] = true;
            $this->setState($messageCompose);

        } else if ($this->lineState['join']) {

            if(empty($this->lineState['menu'])) {

                if($this->lineMessage === '1') {
                    $this->lineState['menu'] = 1.1;
                } else if($this->lineMessage === '2') {
                    $this->lineState['menu'] = 2.1;
                } else {
                    $this->listCommand(false);
                }

            }

            if ($this->lineState['menu'] === 1.1) {

                $messageCompose = "1.1 กรุณากรอก Line Code ที่ได้รับ";
                $this->lineState['menu'] = 1.2;
                $this->setState($messageCompose, true);

            }
            else if ($this->lineState['menu'] === 1.2 || $this->lineState['check'] === "checkJoinMenu1") {

                if($this->lineState['check'] === "checkJoinMenu1"){

                    $this->lineState['user']['birthday'] = $this->lineMessage;
                    $this->lineState['check'] = null;
                    $messageCompose = "กำลังตรวจสอบข้อมูล...";

                    $this->setState($messageCompose);
                    sleep(2);
                    $this->checkJoinMenu1();
                } else {
                    $this->lineState['user']['line_code'] = $this->lineMessage;

                    $messageCompose = "1.2 กรอกวันเดือนปีเกิดของท่าน (เช่น เกิด 1 ต.ค.2533 พิมพ์ 01102533)";
                    $this->lineState['check'] = "checkJoinMenu1";
                    $this->lineState['user']['line_code'] = $this->lineMessage;
                    $this->setState($messageCompose, true);
                }

            } else if ($this->lineState['menu'] === 2.1 || $this->lineState['check'] === "checkJoinMenu2") {

                if($this->lineState['check'] === "checkJoinMenu2"){

                    $this->lineState['user']['password'] = $this->lineMessage;
                    $this->lineState['check'] = null;
                    $messageCompose = "กำลังตรวจสอบข้อมูล...";

                    $this->setState($messageCompose);
                    sleep(2);
                    $this->checkJoinMenu2();
                } else {
                    $messageCompose = "2.1 กรอกรหัส 6 หลักที่ได้รับ";
                    $this->lineState['check'] = "checkJoinMenu2";
                    $this->setState($messageCompose, true);
                }
            }

        }

    }

    /**
     * @param bool $check
     * @return bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    private function getUserMapping($check = false)
    {
        $userMapping = UserMapping::where('line_id', $this->lineUserId)
            ->whereNotNull('user_id')->orWhereNotNull('user_custom');

        if ($check) {
            $userMapping = $userMapping->exists() ?? false;
        } else {
            $userMapping = $userMapping->first();
        }
        return $userMapping;
    }

    /**
     * @param $data
     * @return bool|int
     */
    private function debug($data)
    {
        return \File::put(public_path('line_debug.json'), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * @param $messageCompose
     * @param bool $backMenu
     * @param bool $emptyState
     * @param bool $byLineId
     */
    private function setState($messageCompose, $backMenu = false, $emptyState = false, $byLineId = false)
    {
        if($backMenu) {
            $messageCompose .= "\n-----------------------\nพิมพ์ 0 เพื่อกลับเมนูหลัก";
        }

        if($emptyState){
            $this->lineState = $this->lineStateStruct;
        }

        $result = $byLineId ? $this->pushMessage($this->lineUserId, $messageCompose) : $this->replyMessage($this->replyToken, $messageCompose);

        if ($result['http_status'] === 200) {
            UserMapping::where('line_id', $this->lineUserId)->update(['state' => json_encode($this->lineState)]);
        }
    }

    /**
     * @return mixed
     */
    private function getState()
    {
        $userMapping = UserMapping::where(['line_id' => $this->lineUserId])->first('state');
        return json_decode($userMapping['state'], true);
    }

    /**
     * @return bool
     */
    private function checkJoinMenu1()
    {
        $msg = [];

        $profile = User::where('line_code', ($this->lineState['user']['line_code'] ?? '-9'))->first();

        $lineBirthDay = $this->lineState['user']['birthday'];

        if(strlen($lineBirthDay) === 8){

            $lineBirthDay = substr($lineBirthDay, 0, 2)."-".substr($lineBirthDay, 2, 2)."-".substr($lineBirthDay, 4, 4);

            $birthDay = Carbon::createFromDate($lineBirthDay)->subYears(543)->format('Y-m-d');

        }else{

            $birthDay = $lineBirthDay;

        }

        $fakeUser = $this->lineState['user']['line_code'] === "123456" && $this->lineState['user']['birthday'] === "01102533";

        if($profile || $fakeUser) {
            $fullName = $profile->name ?? 'สมชาย ทดสอบ';

            $msg[] = "สวัสดีคุณ {$fullName}";
            $msg[] = "✅ การตรวจสอบ Line Code ของคุณถูกต้อง!";
        }else{
            $msg[] = "❌ ไม่พบข้อมูล Line Code นี้ในระบบ";
        }

        if($profile['birth_date'] === $birthDay || $fakeUser) {
            $msg[] = "✅ คุณเชื่อมต่อระบบ Message Broadcast System (MBS) สำเร็จแล้ว! 😀 🎉";

            if(!$fakeUser){
                // mapping user
                UserMapping::where('line_id', $this->lineUserId)->update(['user_id' => $profile['id']]);
            }

        }else{
            $msg[] = "❌ ข้อมูล วดป. เกิดไม่ถูกต้อง หรือไม่ตรงกับที่เก็บไว้ในระบบ";
            $msg[] = "❌ เชื่อมต่อไม่สำเร็จ 😔";
        }

        $messageCompose = implode("\n", $msg);

        $this->setState($messageCompose, true, true, true);

        return true;
    }

    /**
     * @return bool
     */
    private function checkJoinMenu2()
    {
        $userCustom = UserCustom::where('password_rand', ($this->lineState['user']['password'] ?? '-9'))->first();
        $fakeUser = $this->lineState['user']['password'] === "1a1a1a";

        if($userCustom['id'] || $fakeUser){
            $msg[] = "✅ คุณเชื่อมต่อระบบ Message Broadcast System (MBS) สำเร็จแล้ว! 😀 🎉";
            // mapping user
            if(!$fakeUser){
                UserMapping::where('line_id', $this->lineUserId)->update(['user_custom' => $userCustom['id']]);
                UserCustom::find($userCustom['id'])->update(['activated' => 1]);
            }

        }else{
            $msg[] = "❌ พบข้อผิดพลาด! รหัส 6 หลักไม่ถูกต้อง";
        }

        $messageCompose = implode("\n", $msg);

        $this->setState($messageCompose, true, true, true);

        return true;
    }

    /**
     * @param bool $member
     */
    private function listCommand($member = true)
    {
        $backMenu = true;
        $messageCompose = [];


        if ($this->lineMessage === '1'){
            if($member) {
                $messageCompose[] = "ขั้นตอนการยกเลิกการเชื่อมต่อกับ RPH-Staff";
                $messageCompose[] = "-----------------------";
                $messageCompose[] = "1. เข้าสู่ระบบเว็บไซต์ ".config('app.url')."/company/member";
                $messageCompose[] = "2. กดที่เมนู Edit User (ชื่อผู้ใช้งาน) > ตัวเลือกการเชื่อมต่อบัญชี Line";
                $messageCompose[] = "3. ติ๊กออกหน้าตัวเลือกการเชื่อมต่อบัญชี Line";
                $messageCompose[] = "4. กด Save เสร็จสิ้น! 😀 🎉";
            }

        } else if ($this->lineMessage === '4'){
            if($member) {
                $userMapping = UserMapping::where(['line_id' => $this->lineUserId])->first('user_id');
                //$this->debug($userMapping);
                $user = User::find($userMapping->user_id ?? '-9');
                if ($user) {
                    $messageCompose[] = "🔹 ชื่อ: {$user->name}";
                    $messageCompose[] = "🔹 ตำแหน่ง: " . ($user->position->name);
                    $messageCompose[] = "🔹 ฝ่าย/แผนก: " . ($user->department->name);
                    $messageCompose[] = "🔹 E-mail: " . ($user->email);
                    $messageCompose[] = "🔹 หากท่านต้องการแก้ไขข้อมูลส่วนตัว สามารถแก้ไขข้อมูลได้ที่ ".config('app.url')."/company/member";
                } else {
                    $messageCompose[] = "บัญชีผู้ใช้งานนี้ เป็นกลุ่มผู้ใช้งานประเภทพิเศษ";
                }
            }
        } else if($this->lineMessage === '2'){
            $messageCompose[] = "ขอความช่วยเหลือการใช้งาน";
            $messageCompose[] = "-----------------------";
            $messageCompose[] = "หากท่านมีข้อสงสัยหรือต้องการสอบถามรายละเอียดเพิ่มเติม กรุณาติดต่อแผนกเทคโนโลยีสารสนเทศ 012-123456 ต่อ 1234 หรือ 1235 😀 🎉";
        } else if($this->lineMessage === '3'){
            $messageCompose[] = "เกี่ยวกับโรงพยาบาลราชพฤกษ์";
            $messageCompose[] = "-----------------------";
            $messageCompose[] = "โรงพยาบาลราชพฤกษ์ (Ratchaphruek Hospital)";
            $messageCompose[] = "ที่อยู่: 456 หมู่ 14 ถนนมิตรภาพ ตำบลในเมือง อำเภอเมือง จังหวัดขอนแก่น รหัสไปรษณีย์ 40000";
            $messageCompose[] = "อีเมล: info@rph.co.th";
            $messageCompose[] = "โทรศัพท์: 043-333-555, 083-6667788";
            $messageCompose[] = "เว็บไซต์: http://www.rph.co.th";
            $messageCompose[] = "แผนที่: https://goo.gl/maps/UsEmsj7T5JHaYyf47";
        }else{
            $messageCompose[] = "พิมพ์หมายเลข เพื่อเลือกฟังก์ชันที่ต้องการใช้งาน";
            $messageCompose[] = "-----------------------";
            $messageCompose[] = ($member ? "[1] ยกเลิกการเชื่อมต่อกับระบบ MBS" : "[1] เชื่อมต่อกับระบบ MBS");
            $messageCompose[] = "[2] ขอความช่วยเหลือการใช้งาน";
            $messageCompose[] = "[3] เกี่ยวกับโรงพยาบาลราชพฤกษ์ (RPH)";
            if($member){
                $messageCompose[] = "[4] แสดงข้อมูลส่วนตัวของฉัน";
            }
            $backMenu = false;
        }

        $this->lineState = $this->lineStateStruct;
        $messageCompose = implode("\n", $messageCompose);
        $this->setState($messageCompose, $backMenu);
    }
}
