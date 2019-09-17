<div class="row">
    <div class="form-group col-md-6">
        {!! Form::label('name', 'ชื่อ - นามสกุล:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('email', 'E-mail:') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>

    @if(empty($user))
    <div class="form-group col-md-6">
        {{ Form::label('password', 'Password:') }}
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('password', 'Confirm Password:') }}
        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
    </div>
    @endif

    <div class="form-group col-md-6">
        {{ Form::label('position', 'ตำแหน่ง:') }}
        {{ Form::select('position_id', $positions, null, ['class' => 'form-control', 'placeholder' => 'เลือกตำแหน่ง']) }}
    </div>


    <div class="form-group col-md-6">
        {{ Form::label('department', 'แผนก:') }}
        {{ Form::select('department_id', $departments, null, ['class' => 'form-control', 'placeholder' => 'เลือกแผนก']) }}
    </div>

    @if($user->lineMapping ?? false)
        <div class="form-group col-md-6">
            <label>
                {{ Form::hidden('unlink_line', 0) }}
                {{ Form::checkbox('unlink_line', 1, true) }} การเชื่อมต่อบัญชี Line
            </label>
        </div>
    @else
        <div class="form-group col-md-12">
            <p>ข้อมูลการเชื่อมต่อ Line App</p>
            <div class="row alert alert-info m-0 px-0">
                <div class="col-md-6">
                    {!! Form::label('line_code', 'Line Code:') !!}
                    {!! Form::text('line_code', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('birth_date', 'วันเดือนปีเกิด:') !!}
                    {!! Form::date('birth_date', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    @endif

    <div class="form-group col-md-6">
        <label>
            {{ Form::hidden('activated', 0) }}
            {{ Form::checkbox('activated', 1, $user->activated ?? true) }} เปิดใช้งานบัญชี
        </label>
    </div>

    <div class="form-group col-md-12">
        {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
        <a href="../" class="btn btn-danger">Cancel</a>
    </div>

</div>
