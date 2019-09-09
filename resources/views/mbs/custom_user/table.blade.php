<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Detail</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($model as $data)
            <tr id="data-row-{{ $data->id }}">
                <td>{!! $data->name !!}</td>
                <td>{!! $data->detail !!}</td>
                <td>
                    <div>
                        <a href="{!! route('mbs.user-custom.edit', [$data->id]) !!}" class='btn btn-success btn-sm m-r-5'><i class="ti ti-pencil-alt"></i> Edit</a>
                        {!! $data->activated ? null : Form::button('<i class="ti ti-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger confirm-remove', 'data-action' => route('mbs.user-custom.destroy', $data->id)]) !!}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
