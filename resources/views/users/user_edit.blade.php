@extends('users._layout')

@section('user_content')
    <!-- /.left-aside-column-->
    <div class="right-aside">
        <div class="card-title h3">
            Edit info
            <hr>
        </div>
        <div>
            @include ('errors.list')

            {!! Form::model($user, ['route' => ['company.member.update', $user->id], 'method' => 'patch']) !!}
            @include('users.user_fields')
            {!! Form::close() !!}
        </div>
    </div>
    <!-- /.left-right-aside-column-->
@endsection
