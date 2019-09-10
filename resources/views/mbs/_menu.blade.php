<a @click="newMessage" href="javascript:void(0)" class="btn btn-success m-b-20 btn-block waves-effect waves-light">
    <i class="fa fa-plus"></i> ข้อความใหม่
</a>

<h5 class="m-t-10"><i class="fa fa-users"></i> ผู้ติดต่อ</h5>
<ul class="nav scroll">

    <li v-for="(data, index) in history_contact_list.list" class="nav-item">
        <a class="nav-link" href="javascript:void(0)" @click="loadMessage(data.group_id)"><i class="fa fa-user"></i>@{{ data.group.name | stringLimit(40) }}</a>
    </li>

</ul>

<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="/mbs/group-custom"><i class="fa fa-inbox"></i> จัดการกลุ่มผู้รับข้อความ</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/mbs/user-custom"><i class="fa fa-inbox"></i> จัดการผู้ใช้งานพิเศษ</a>
    </li>
</ul>
