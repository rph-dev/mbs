const $app = new Vue({
    el: '#app-message',
    data: {
        el_tags:{
            select2_contact: null
        },
        prop_val: {
            view_message: false,
            show_input_text: true
        },
        fields: {
            files: [],
            select2_contact: null,
            message_type: 'text'
        },
        messages: {
            group_id: null
        },
        history_contact_list: {},
        contact_list: [
            {
                group_name: null,
                data: [
                    {}
                ]
            }
        ],
    },
    created() {
        this.el_tags.select2_contact = "#contact_to";
    },
    async mounted() {

        // init select2 contact
        let select2_contact = $(this.el_tags.select2_contact).select2();

        let _this = this;
        select2_contact.on('select2:unselect || select2:select', function (e) {
            //console.log(data);
            _this.changeContact();
        });

        if(this.initContact()){
            await this.initHistoryContact();
            await this.loadMessage(this.history_contact_list.current_group_id);
        }
    },
    methods: {
        onChangeMessageType(messageType = 'text') {

            if(messageType === 'text'){
                this.$refs.files.multiple = true;
                this.prop_val.show_input_text = true;
            }else if(messageType === 'image' || messageType === 'video'){
                this.$refs.files.multiple = false;
                this.prop_val.show_input_text = false;
            }
            this.fields.message_type = messageType;
        },
        async changeContact() {

            if ($(this.el_tags.select2_contact).val().length) {
                await this.loadContact();
            }
        },
        newMessage(){
            this.prop_val.view_message = false;

            this.messages = [];
            //$(this.el_tags.select2_contact).next(".select2-container").show();
            $(this.el_tags.select2_contact).val(null).trigger('change').select2('focus');
        },
        async loadContact() {
            await this.pleaseWait();
            let _this = this;
            await axios.post('/mbs/load-contact', {
                contact_id: $(_this.el_tags.select2_contact).val()
            }).then(response => {

                _this.messages = {...response.data};

                _this.filterContact(response.data.group_list, true);
                // console.log();

                if(response.data.group_list.length){
                    $(_this.el_tags.select2_contact).val(response.data.group_list).trigger('change');
                }

            }).catch(error => {

            });

            await this.scrollToEnd();

            await this.pleaseWait(true);
        },
        async loadMessage(group_id) {
            this.prop_val.view_message = true;

            //$(this.el_tags.select2_contact).next(".select2-container").hide();
            //$(this.el_tags.select2_contact).val(null).trigger('change');

            await this.pleaseWait();

            axios.get('/mbs/load-message', {
                params: {
                    group_id: group_id
                }
            }).then(response => {

                let _this = this;

                _this.messages = {...response.data};

                _this.filterContact(response.data.group_list, true);
                // console.log();

                if(response.data.group_list.length){
                    $(_this.el_tags.select2_contact).val(response.data.group_list).trigger('change');
                }

            }).catch(error => {

            });

            await this.pleaseWait(true);

            await this.scrollToEnd();

        },
        async initHistoryContact() {
            let _this = this;

            _this.prop_val.view_message = true;

            //$(this.el_tags.select2_contact).next(".select2-container").hide();
            //$(this.el_tags.select2_contact).val(null).trigger('change');

            await axios.get('/mbs/init-history-contact').then(response => {

                _this.$set(_this.history_contact_list, 'list', response.data.history_contact_list.map(item => {
                    let list_id = item.group.map(group => group.contact_id);
                    return { group_id: item.group_id, group: { id: list_id } };
                }));

                _this.$set(_this.history_contact_list, 'current_group_id', response.data.history_contact_list[0].group_id);

                //console.log(_this.history_contact_list.current_group_id);

            }).catch(error => {

            });

            await _this.history_contact_list.list.forEach((data, index) => {
                let cartesianObject = [...data.group.id];
                try {
                    setTimeout(function(){
                        _this.history_contact_list.list[index].group.name = _this.filterContact(cartesianObject);
                    }, 500);
                } catch (err) {
                    throw new Error('This does NOT get caught by Vue');
                }
            });
            setTimeout(() => _this.$forceUpdate(), 500);
        },
        fnTest(data = ""){
            alert('test: '+data)
        },
        async initContact() {

            await axios.get('/mbs/init-contact').then(response => {

                this.contact_list = response.data;

                let contact_list = response.data.map((item) => item.data);

                let merged_contact_list = [].concat.apply([], contact_list);

                this.$set(this.prop_val, 'merged_contact_list', merged_contact_list);

            }).catch(error => {

            });

            return true;
        },
        filterContact(group_list, setTitle = false) {

            let _this = this;

            let group_name_list = _this.prop_val.merged_contact_list.filter(item => {
                return group_list.indexOf(item.key) > -1;
            }).map(data => data.value).join(", ");

            if(setTitle) this.$set(this.messages, 'group_name_list', group_name_list);
            //console.log(this.messages.group_name_list);

            return group_name_list;
        },
        pleaseWait(undo = false) {
            if (undo) {
                $.unblockUI();
            }else{
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
            }
        },
        onConfirmSubmit: function() {
            if(!$(this.el_tags.select2_contact).val().length){
                return Swal.fire("พบข้อผิดพลาด!", "กรุณาระบุผู้รับข้อความ", "error")
            }else if(this.fields.message_type === 'text'){
                if(!this.fields.title) {
                    return Swal.fire("พบข้อผิดพลาด!", "กรุณาระบุ หัวเรื่องข้อความ:", "error");
                }else if(!this.fields.detail) {
                    return Swal.fire("พบข้อผิดพลาด!", "กรุณาระบุ เนื้อหาข้อความ:", "error");
                }
            } else if(this.fields.message_type === 'image' || this.fields.message_type === 'video'){
                if(!this.fields.files.length) return Swal.fire("พบข้อผิดพลาด!", "กรุณาระบุเลือกไฟล์", "error");
            }
            //
            Swal.fire({
                title: "ต้องการจะส่งข้อความนี้ไปที่ผู้ติดต่อ หรือไม่ ?",
                text: "ยืนยันการ Broadcast",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#36bea6",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก"
            }).then(async (result) => {
                if (result.value) {
                    if(await this.submitMsg()) Swal.fire("Broadcast ข้อความเรียบร้อย!", this.messages.group_name_list, "success");
                }
            });
        },
        scrollToEnd: function () {

            setTimeout(() => {
                let container = this.$el.querySelector("#message-container");
                container.scrollTop = container.scrollHeight;
            }, 500);
        },
        submitMsg: async function () {

            let submit_status = false;
            /*
             Initialize the form data
           */
            let formData = new FormData();

            formData.append('title', this.fields.title || "");
            formData.append('detail', this.fields.detail || "");
            formData.append('message_type', this.fields.message_type);
            formData.append('contact_id', $(this.el_tags.select2_contact).val());

            if (this.fields.files.length) {
                /*
                  Iterate over any file sent over appending the files
                  to the form data.
                */
                for (let i = 0; i < this.fields.files.length; i++) {
                    let file = this.fields.files[i];
                    formData.append(`mbs_files[${i}]`, file);
                }
            }
            this.pleaseWait();
            /*
              Make the request to the POST /multiple-files URL
            */
            await axios.post('/mbs/store',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                console.log('SUCCESS!!');
                submit_status = true;
                let _this = this;
                _this.fields.title = null;
                _this.fields.detail = null;
                _this.$refs.files.value = null;
                _this.fields.errors = null;
                //
                _this.messages = {...response.data};

                _this.filterContact(response.data.group_list, true);
                // console.log();
                _this.initHistoryContact();
            })
                .catch(error => {
                    if(error.response.data) {
                        console.log("Error");
                        submit_status = false;
                        let errors = Object.values(error.response.data.errors);
                        errors = errors.flat();
                        Swal.fire({
                            type: 'error',
                            title: 'พบข้อผิดพลาด!',
                            customClass: {
                                content: 'text-left alert alert-danger mb-0',
                            },
                            html: errors.map(item => `<i class="ti-close text-danger"></i> ${item}<br>`).join("")
                        });
                    }
                });

            await this.scrollToEnd();

            await this.pleaseWait(true);

            return submit_status;
        },
        handleFilesUpload(){
            /*
            Handles a change on the file upload
            */
            this.fields.files = this.$refs.files.files;
        }
    },
    filters: {
        stringLimit: function(value = "", limit) {
            if (value.length > limit) {
                value = value.substring(0, (limit - 3)) + '...';
            }
            return value
        },
    },
});
