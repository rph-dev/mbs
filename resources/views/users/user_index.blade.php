@extends('users._layout')

@section('user_content')
    <!-- /.left-aside-column-->
    <div class="right-aside">
        <div class="right-page-header m-4">
            <div class="card-title">
                ทั้งหมด ({{ $users->total() }} คน)
            </div>
        </div>
        <div class="table-responsive">
            <table id="demo-foo-addrow" class="table m-t-30 table-hover table-striped no-wrap contact-list" data-page-size="10">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Line Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ ((($_GET['page'] ?? 1)-1) *50)+$loop->iteration }}</td>
                        <td><a href="/company/member/{{ $user->id }}">{{ $user->name }}</a></td>
                        <td><span class="label label-inverse">{{ $user->position->name }}</span></td>
                        <td>{{ $user->department->name }}</td>
                        <td>{{ $user->line_code }}</td>
                        <td>{!! $user->lineMapping ? '<i class="fa fa-commenting-o text-success"></i> เชื่อมต่อแล้ว' : '<i class="fa fa-commenting-o text-danger"></i> ยังไม่ได้เชื่อมต่อ' !!}</td>
                        <td>
                            <a href="/company/member/{{ $user->id }}/edit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="ti ti-pencil-alt" aria-hidden="true"></i> Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- .left-aside-column-->
        <div class="pull-right">
            {{ $users->links() }}
        </div>
    </div>
    <!-- /.left-right-aside-column-->
@endsection
