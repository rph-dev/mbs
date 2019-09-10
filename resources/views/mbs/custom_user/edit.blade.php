@extends('mbs._layout')

@section('title')
    Message Broadcast System (MBS)
@endsection

@push('head_css')

@endpush

@section('mbs_content')
    <div class="card mb-0">
        <div class="card-body">
            <h4 class="card-title">Edit กลุ่มผู้รับข้อความ</h4>
            <hr>

            @include ('errors.list')

            {!! Form::model($model, ['route' => ['mbs.user-custom.update', $model->id], 'method' => 'patch']) !!}
            @include('mbs.custom_user.fields')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('js')
<script src="https://malsup.github.io/jquery.blockUI.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
@endpush
