<div class="row">
    <!-- Name Field -->
    <div class="form-group col-md-12">
        {!! Form::label('contact_type_id', 'ผู้ติดต่อ:') !!}
        {!! Form::select('contact_type_id[]', $model->contact_type_id, $model->groupCustomUserList, ['class' => 'form-control', 'multiple' => true, 'id' => 'contact_type_id', 'style' => 'width:100%;']) !!}
    </div>

    <!-- Code Field -->
    <div class="form-group col-md-12">
        {!! Form::label('name', 'ชื่อกลุ่ม:') !!}
        {!! Form::text('name', $model->name ?? old('name'), ['class' => 'form-control']) !!}
    </div>

    <!-- Name Field -->
    <div class="form-group col-md-12">
        {!! Form::label('detail', 'รายละเอียด (ไม่บังคับ):') !!}
        {!! Form::textarea('detail', $model->detail ?? old('detail'), ['class' => 'form-control']) !!}
    </div>

    <!-- Submit Field -->
    <div class="col-md-12">
        {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
        <a href="{!! route('mbs.group-custom.index') !!}" class="btn btn-danger">Cancel</a>
    </div>
</div>
