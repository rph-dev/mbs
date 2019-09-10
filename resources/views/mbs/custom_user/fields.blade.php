<div class="row">

    <!-- Code Field -->
    <div class="form-group col-md-12">
        {!! Form::label('name', 'ชื่อผู้ใช้งาน:') !!}
        {!! Form::text('name', $model->name ?? old('name'), ['class' => 'form-control']) !!}
    </div>

    <!-- Code Field -->
    <div class="form-group col-md-12">
        {!! Form::label('password_rand', 'รหัส OTP 6 หลัก:') !!}
        {!! Form::text('password_rand', $model->password_rand ?? old('password_rand'), ['class' => 'form-control', 'disabled' => $model->password_rand]) !!}
    </div>

    <!-- Name Field -->
    <div class="form-group col-md-12">
        {!! Form::label('detail', 'รายละเอียด (ไม่บังคับ):') !!}
        {!! Form::textarea('detail', $model->detail ?? old('detail'), ['class' => 'form-control']) !!}
    </div>

    <!-- Submit Field -->
    <div class="col-md-12">
        {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
        <a href="{!! route('mbs.user-custom.index') !!}" class="btn btn-danger">Cancel</a>
    </div>
</div>
