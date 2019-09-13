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

        #select2-contact_to-results {
            max-height: 650px;
        }

        .tabcontent-border {
            border: 1px solid #ddd;
            border-top: 0px;
        }
    </style>
@endpush

@section('mbs_filter')
    <div class="row">
        <div class="col-md-12">

            <div class="py-2">

                <select multiple id="contact_to" class="form-control" style="width: 100%;">
                    <optgroup v-for="(contact_group, index2) in contact_list" :label="contact_list[index2].group_name">

                        <option v-for="(item, index) in contact_group.data" :value="item.key" :key="item.key">@{{ item.value }}
                        </option>

                    </optgroup>

                </select>

            </div>

        </div>
    </div>

@endsection

@section('mbs_content')
    <div class="bg-white p-10">

        <ul id="message-container" class="list-unstyled message-scroll">
            <li class="media p-10" v-for="(data, index) in messages.message_list">
                <img class="d-flex mr-3" src="/img/messaging-icon.png" width="60" alt="Generic placeholder image">
                <div class="media-body">
                    <span class="mt-0 mb-1 font-weight-bold">@{{ data.message.title }}</span> <span>(เมื่อ: @{{ data.message.created_at }}) โดย: @{{ `${data.message.user_profile.name}` }} (@{{ data.message.user_profile.department.name }})</span><br>
                    <p style="white-space: pre;">@{{ data.message.detail }}</p>
                    <div v-if="data.message.type === 'text' && data.message.files.length">
                        <span>ไฟล์ที่แนบ:</span>
                        <ul>
                            <li v-for="(file, file_index) in data.message.files">
                                <a target="_blank" :href="`${file.file_path}${file.file_name}`">(@{{ file.file_type }}) @{{ `${file.file_name_old}` }}</a>
                            </li>
                        </ul>
                    </div>
                    <div v-else-if="data.message.type === 'image'">
                        <a target="_blank" :href="data.message.files[0].file_path+data.message.files[0].file_name"><img :src="data.message.files[0].file_path+data.message.files[0].file_name" alt="" class="img-responsive img-thumbnail" width="150px"></a>
                    </div>
                    <div v-else-if="data.message.type === 'video'">
                        <a target="_blank" :href="data.message.files[0].file_path+data.message.files[0].file_name"><img :src="data.message.files[0].file_path+data.message.files[0].video_thumbnail" alt="" class="img-responsive img-thumbnail" width="150px"></a>
                    </div>
                    <hr>
                </div>
            </li>
        </ul>

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a @click="onChangeMessageType('text')" class="nav-link active" data-toggle="tab" href="#text-message" role="tab" aria-selected="true"><span><i class="fa fa-file-text-o"></i> Text</span></a>
            </li>
            <li class="nav-item">
                <a @click="onChangeMessageType('image')" class="nav-link" data-toggle="tab" href="#image-message" role="tab" aria-selected="false"><span><i class="fa fa-file-image-o"></i> Image</span></a>
            </li>
            <li class="nav-item">
                <a @click="onChangeMessageType('video')" class="nav-link" data-toggle="tab" href="#video-message" role="tab" aria-selected="false"><span><i class="fa fa-file-video-o"></i> Video</span></a>
            </li>
        </ul>

        <!-- Tab panes -->
        <form action="javascript:void(0)" accept-charset="UTF-8" enctype="multipart/form-data" @submit="onConfirmSubmit">

            <div class="tab-content tabcontent-border">
                <!-- Detail Field -->
                <div class="form-group col-md-12 pt-3" v-show="prop_val.show_input_text">
                    {!! Form::label('detail', 'หัวเรื่อง:') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'v-model' => 'fields.title']) !!}
                </div>
                <div class="form-group col-md-12" v-show="prop_val.show_input_text">
                    {!! Form::label('detail', 'เนื้อหา:') !!}
                    {!! Form::textarea('detail', null, ['class' => 'form-control', 'v-model' => 'fields.detail']) !!}
                </div>

                <div class="tab-pane active" id="text-message" role="tabpanel">

                    <div class="col-md-12">
                        {!! Form::label('detail', 'แนบไฟล์: ') !!}
                        <span class="font-12">*ประเภทไฟล์ที่รองรับ: jpeg, png, jpg, gif, doc, docx, xls, xlsx, ppt, pptx, pdf (เลือกอัพโหลดได้ทีละหลายไฟล์ ไฟล์ละไม่เกิน 4MB)</span>
                    </div>

                </div>
                <div class="tab-pane p-20" id="image-message" role="tabpanel">
                    <div class="form-group col-md-12 pt-3" v-show="!prop_val.show_input_text">
                        <a href="javascript:void(0)" @click="prop_val.show_input_text = true"><i class="ti-comment"></i> เพิ่มรายละเอียด</a>
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('detail', 'แนบไฟล์: ') !!}
                        <span class="font-12">*ประเภทไฟล์ที่รองรับ: jpeg, png, jpg, gif (อัพโหลดได้ไฟล์ละไม่เกิน 2MB)</span>
                    </div>
                </div>
                <div class="tab-pane p-20" id="video-message" role="tabpanel">
                    <div class="form-group col-md-12 pt-3" v-show="!prop_val.show_input_text">
                        <a href="javascript:void(0)" @click="prop_val.show_input_text = true"><i class="ti-comment"></i> เพิ่มรายละเอียด</a>
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('detail', 'แนบไฟล์: ') !!}
                        <span class="font-12">*ประเภทไฟล์ที่รองรับ: mp4, mov, avi (อัพโหลดได้ไฟล์ละไม่เกิน 100MB)</span>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    {!! Form::file('files[]', ['class' => 'form-control', 'multiple' => true, 'ref' => 'files', '@change' => 'handleFilesUpload']) !!}
                </div>
                <div class="col-md-12 col-lg-12 pb-3">
                    {!! Form::submit('Send Message', ['class' => 'btn btn-success btn-block', 'id' => 'btn-submit']) !!}
                </div>
            </div>
        </form>

    </div>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{ mix('/js/mbs/home.index.js') }}" type="text/javascript"></script>
@endpush
