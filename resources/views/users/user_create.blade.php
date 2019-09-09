@extends('users._layout')

@section('user_content')
    <!-- /.left-aside-column-->
    <div class="right-aside">
        <div class="card-title h3">
            Add new member
            <hr>
        </div>
        <div>
            @include ('errors.list')

            {!! Form::open(['route' => 'company.member.store']) !!}
            @include('users.user_fields')
            {!! Form::close() !!}
        </div>
    </div>
    <!-- /.left-right-aside-column-->
@endsection
