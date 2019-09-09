@extends('mbs._layout')

@section('title')
    Message Broadcast System (MBS)
@endsection

@section('mbs_content')
    <div class="card mb-0">
        <div class="card-body">
            <h4 class="card-title">กลุ่มผู้รับข้อความ</h4>

            <div class="float-right mb-3">
                <a href="{!! route('mbs.group-custom.create') !!}" class="btn btn-success btn-rounded"><i class="ti ti-plus"></i> สร้างกลุ่มใหม่</a>
            </div>

            @include('mbs.custom_group.table')

            {{ $model->links() }}
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $('.confirm-remove').click(function(){
        var url = $(this).attr('data-action');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: "คุณต้องการลบข้อมูลหรือใม่ ?",
            text: "ยืนยันการลบข้อมูลนี้ออก",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function(result) {
                        $('#data-row-' + result.data).fadeOut();
                        Swal.fire(
                            'ลบข้อมูลเรียบร้อย!',
                            result.message, "success"
                        )
                    }
                });
            }
        });
    });
</script>
@endpush
