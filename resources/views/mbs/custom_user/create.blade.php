@extends('mbs._layout')

@section('title')
    Message Broadcast System (MBS)
@endsection

@push('css')

@endpush

@section('mbs_content')
    <div class="card mb-0">
        <div class="card-body">
            <h4 class="card-title">เพิ่มผู้ใช้งานพิเศษ</h4>
            <hr>

            @include ('errors.list')

            {!! Form::open(['route' => 'mbs.user-custom.store']) !!}
            @include('mbs.custom_user.fields')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('js')
<script src="https://malsup.github.io/jquery.blockUI.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

@endpush
