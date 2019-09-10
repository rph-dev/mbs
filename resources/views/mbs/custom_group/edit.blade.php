@extends('mbs._layout')

@section('title')
    Message Broadcast System (MBS)
@endsection

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: #009efb;
            color: #fff;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }
        .select2-container--default .select2-results>.select2-results__options {
            max-height: 350px;
        }
    </style>
@endpush

@section('mbs_content')
    <div class="card mb-0">
        <div class="card-body">
            <h4 class="card-title">Edit กลุ่มผู้รับข้อความ</h4>
            <hr>

            @include ('errors.list')

            {!! Form::model($model, ['route' => ['mbs.group-custom.update', $model->id], 'method' => 'patch']) !!}
            @include('mbs.custom_group.fields')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="https://malsup.github.io/jquery.blockUI.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $('#contact_type_id').select2();
</script>
@endpush
