!function(t){var e={};function r(n){if(e[n])return e[n].exports;var o=e[n]={i:n,l:!1,exports:{}};return t[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=t,r.c=e,r.d=function(t,e,n){r.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:n})},r.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},r.t=function(t,e){if(1&e&&(t=r(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)r.d(n,o,function(e){return t[e]}.bind(null,o));return n},r.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return r.d(e,"a",e),e},r.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},r.p="/",r(r.s=41)}({0:function(t,e,r){t.exports=r(43)},41:function(t,e,r){t.exports=r(42)},42:function(t,e,r){"use strict";r.r(e);var n=r(0),o=r.n(n);function i(t){return function(t){if(Array.isArray(t)){for(var e=0,r=new Array(t.length);e<t.length;e++)r[e]=t[e];return r}}(t)||function(t){if(Symbol.iterator in Object(t)||"[object Arguments]"===Object.prototype.toString.call(t))return Array.from(t)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()}function a(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),r.push.apply(r,n)}return r}function s(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?a(r,!0).forEach(function(e){c(t,e,r[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):a(r).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))})}return t}function c(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}function u(t,e,r,n,o,i,a){try{var s=t[i](a),c=s.value}catch(t){return void r(t)}s.done?e(c):Promise.resolve(c).then(n,o)}function l(t){return function(){var e=this,r=arguments;return new Promise(function(n,o){var i=t.apply(e,r);function a(t){u(i,n,o,a,s,"next",t)}function s(t){u(i,n,o,a,s,"throw",t)}a(void 0)})}}var f,h,p,d,g,v,y;new Vue({el:"#app-message",data:{el_tags:{select2_contact:null},prop_val:{view_message:!1,show_input_text:!0},fields:{files:[],select2_contact:null,message_type:"text"},messages:{group_id:null},history_contact_list:{},contact_list:[{group_name:null,data:[{}]}]},created:function(){this.el_tags.select2_contact="#contact_to"},mounted:(y=l(o.a.mark(function t(){var e,r;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(e=$(this.el_tags.select2_contact).select2(),r=this,e.on("select2:unselect || select2:select",function(t){r.changeContact()}),!this.initContact()){t.next=8;break}return t.next=6,this.initHistoryContact();case 6:return t.next=8,this.loadMessage(this.history_contact_list.current_group_id);case 8:case"end":return t.stop()}},t,this)})),function(){return y.apply(this,arguments)}),methods:{onChangeMessageType:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"text";"text"===t?(this.$refs.files.multiple=!0,this.prop_val.show_input_text=!0):"image"!==t&&"video"!==t||(this.$refs.files.multiple=!1,this.prop_val.show_input_text=!1),this.fields.message_type=t},changeContact:(v=l(o.a.mark(function t(){return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(!$(this.el_tags.select2_contact).val().length){t.next=3;break}return t.next=3,this.loadContact();case 3:case"end":return t.stop()}},t,this)})),function(){return v.apply(this,arguments)}),newMessage:function(){this.prop_val.view_message=!1,this.messages=[],$(this.el_tags.select2_contact).val(null).trigger("change").select2("focus")},loadContact:(g=l(o.a.mark(function t(){var e;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.pleaseWait();case 2:return e=this,t.next=5,axios.post("/mbs/load-contact",{contact_id:$(e.el_tags.select2_contact).val()}).then(function(t){e.messages=s({},t.data),e.filterContact(t.data.group_list,!0),t.data.group_list.length&&$(e.el_tags.select2_contact).val(t.data.group_list).trigger("change")}).catch(function(t){});case 5:return t.next=7,this.scrollToEnd();case 7:return t.next=9,this.pleaseWait(!0);case 9:case"end":return t.stop()}},t,this)})),function(){return g.apply(this,arguments)}),loadMessage:(d=l(o.a.mark(function t(e){var r=this;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return this.prop_val.view_message=!0,t.next=3,this.pleaseWait();case 3:return axios.get("/mbs/load-message",{params:{group_id:e}}).then(function(t){var e=r;e.messages=s({},t.data),e.filterContact(t.data.group_list,!0),t.data.group_list.length&&$(e.el_tags.select2_contact).val(t.data.group_list).trigger("change")}).catch(function(t){}),t.next=6,this.pleaseWait(!0);case 6:return t.next=8,this.scrollToEnd();case 8:case"end":return t.stop()}},t,this)})),function(t){return d.apply(this,arguments)}),initHistoryContact:(p=l(o.a.mark(function t(){var e;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return(e=this).prop_val.view_message=!0,t.next=4,axios.get("/mbs/init-history-contact").then(function(t){e.$set(e.history_contact_list,"list",t.data.history_contact_list.map(function(t){var e=t.group.map(function(t){return t.contact_id});return{group_id:t.group_id,group:{id:e}}})),e.$set(e.history_contact_list,"current_group_id",t.data.history_contact_list[0].group_id)}).catch(function(t){});case 4:return t.next=6,e.history_contact_list.list.forEach(function(t,r){var n=i(t.group.id);try{setTimeout(function(){e.history_contact_list.list[r].group.name=e.filterContact(n)},500)}catch(t){throw new Error("This does NOT get caught by Vue")}});case 6:setTimeout(function(){return e.$forceUpdate()},500);case 7:case"end":return t.stop()}},t,this)})),function(){return p.apply(this,arguments)}),fnTest:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";alert("test: "+t)},initContact:(h=l(o.a.mark(function t(){var e=this;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,axios.get("/mbs/init-contact").then(function(t){e.contact_list=t.data;var r=t.data.map(function(t){return t.data}),n=[].concat.apply([],r);e.$set(e.prop_val,"merged_contact_list",n)}).catch(function(t){});case 2:return t.abrupt("return",!0);case 3:case"end":return t.stop()}},t)})),function(){return h.apply(this,arguments)}),filterContact:function(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1],r=this,n=r.prop_val.merged_contact_list.filter(function(e){return t.indexOf(e.key)>-1}).map(function(t){return t.value}).join(", ");return e&&this.$set(this.messages,"group_name_list",n),n},pleaseWait:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0];t?$.unblockUI():$.blockUI({css:{border:"none",padding:"15px",backgroundColor:"#000","-webkit-border-radius":"10px","-moz-border-radius":"10px",opacity:.5,color:"#fff"}})},onConfirmSubmit:function(){if(!$(this.el_tags.select2_contact).val().length)return Swal.fire("พบข้อผิดพลาด!","กรุณาระบุผู้รับข้อความ","error");if("text"===this.fields.message_type){if(!this.fields.title)return Swal.fire("พบข้อผิดพลาด!","กรุณาระบุ หัวเรื่องข้อความ:","error");if(!this.fields.detail)return Swal.fire("พบข้อผิดพลาด!","กรุณาระบุ เนื้อหาข้อความ:","error")}else if(("image"===this.fields.message_type||"video"===this.fields.message_type)&&!this.fields.files.length)return Swal.fire("พบข้อผิดพลาด!","กรุณาระบุเลือกไฟล์","error");var t=this;Swal.fire({title:"ต้องการจะส่งข้อความนี้ไปที่ผู้ติดต่อ หรือไม่ ?",text:"ยืนยันการ Broadcast",type:"warning",showCancelButton:!0,confirmButtonColor:"#36bea6",confirmButtonText:"ยืนยัน",cancelButtonText:"ยกเลิก"}).then(function(e){e.value&&(t.submitMsg(),Swal.fire("Broadcast ข้อความเรียบร้อย!",t.messages.group_name_list,"success"))})},scrollToEnd:function(){var t=this;setTimeout(function(){var e=t.$el.querySelector("#message-container");e.scrollTop=e.scrollHeight},500)},submitMsg:(f=l(o.a.mark(function t(){var e,r,n,i=this;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if((e=new FormData).append("title",this.fields.title||""),e.append("detail",this.fields.detail||""),e.append("message_type",this.fields.message_type),e.append("contact_id",$(this.el_tags.select2_contact).val()),this.fields.files.length)for(r=0;r<this.fields.files.length;r++)n=this.fields.files[r],e.append("mbs_files[".concat(r,"]"),n);return this.pleaseWait(),t.next=9,axios.post("/mbs/store",e,{headers:{"Content-Type":"multipart/form-data"}}).then(function(t){console.log("SUCCESS!!");var e=i;e.fields.title=null,e.fields.detail=null,e.$refs.files.value=null,e.fields.errors=t.data.errors,e.messages=s({},t.data),e.filterContact(t.data.group_list,!0),e.initHistoryContact()}).catch(function(t){if(console.log("Error"),t.response.data){var e=Object.values(t.response.data.errors);e=e.flat(),i.fields.errors=e,Swal.fire({type:"error",title:"พบข้อผิดพลาด!",customClass:{content:"text-left alert alert-danger mb-0"},html:!0,text:e.map(function(t){return'<i class="ti-close text-danger"></i> '+t+"<br>"}).join("")})}});case 9:return t.next=11,this.scrollToEnd();case 11:return t.next=13,this.pleaseWait(!0);case 13:case"end":return t.stop()}},t,this)})),function(){return f.apply(this,arguments)}),handleFilesUpload:function(){this.fields.files=this.$refs.files.files}},filters:{stringLimit:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",e=arguments.length>1?arguments[1]:void 0;return t.length>e&&(t=t.substring(0,e-3)+"..."),t}}})},43:function(t,e,r){var n=function(t){"use strict";var e,r=Object.prototype,n=r.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},i=o.iterator||"@@iterator",a=o.asyncIterator||"@@asyncIterator",s=o.toStringTag||"@@toStringTag";function c(t,e,r,n){var o=e&&e.prototype instanceof g?e:g,i=Object.create(o.prototype),a=new S(n||[]);return i._invoke=function(t,e,r){var n=l;return function(o,i){if(n===h)throw new Error("Generator is already running");if(n===p){if("throw"===o)throw i;return C()}for(r.method=o,r.arg=i;;){var a=r.delegate;if(a){var s=j(a,r);if(s){if(s===d)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===l)throw n=p,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=h;var c=u(t,e,r);if("normal"===c.type){if(n=r.done?p:f,c.arg===d)continue;return{value:c.arg,done:r.done}}"throw"===c.type&&(n=p,r.method="throw",r.arg=c.arg)}}}(t,r,a),i}function u(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=c;var l="suspendedStart",f="suspendedYield",h="executing",p="completed",d={};function g(){}function v(){}function y(){}var m={};m[i]=function(){return this};var _=Object.getPrototypeOf,w=_&&_(_(k([])));w&&w!==r&&n.call(w,i)&&(m=w);var x=y.prototype=g.prototype=Object.create(m);function b(t){["next","throw","return"].forEach(function(e){t[e]=function(t){return this._invoke(e,t)}})}function O(t){var e;this._invoke=function(r,o){function i(){return new Promise(function(e,i){!function e(r,o,i,a){var s=u(t[r],t,o);if("throw"!==s.type){var c=s.arg,l=c.value;return l&&"object"==typeof l&&n.call(l,"__await")?Promise.resolve(l.__await).then(function(t){e("next",t,i,a)},function(t){e("throw",t,i,a)}):Promise.resolve(l).then(function(t){c.value=t,i(c)},function(t){return e("throw",t,i,a)})}a(s.arg)}(r,o,e,i)})}return e=e?e.then(i,i):i()}}function j(t,r){var n=t.iterator[r.method];if(n===e){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=e,j(t,r),"throw"===r.method))return d;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return d}var o=u(n,t.iterator,r.arg);if("throw"===o.type)return r.method="throw",r.arg=o.arg,r.delegate=null,d;var i=o.arg;return i?i.done?(r[t.resultName]=i.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,d):i:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,d)}function E(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function L(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function S(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(E,this),this.reset(!0)}function k(t){if(t){var r=t[i];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var o=-1,a=function r(){for(;++o<t.length;)if(n.call(t,o))return r.value=t[o],r.done=!1,r;return r.value=e,r.done=!0,r};return a.next=a}}return{next:C}}function C(){return{value:e,done:!0}}return v.prototype=x.constructor=y,y.constructor=v,y[s]=v.displayName="GeneratorFunction",t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===v||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,y):(t.__proto__=y,s in t||(t[s]="GeneratorFunction")),t.prototype=Object.create(x),t},t.awrap=function(t){return{__await:t}},b(O.prototype),O.prototype[a]=function(){return this},t.AsyncIterator=O,t.async=function(e,r,n,o){var i=new O(c(e,r,n,o));return t.isGeneratorFunction(r)?i:i.next().then(function(t){return t.done?t.value:i.next()})},b(x),x[s]="Generator",x[i]=function(){return this},x.toString=function(){return"[object Generator]"},t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},t.values=k,S.prototype={constructor:S,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(L),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function o(n,o){return s.type="throw",s.arg=t,r.next=n,o&&(r.method="next",r.arg=e),!!o}for(var i=this.tryEntries.length-1;i>=0;--i){var a=this.tryEntries[i],s=a.completion;if("root"===a.tryLoc)return o("end");if(a.tryLoc<=this.prev){var c=n.call(a,"catchLoc"),u=n.call(a,"finallyLoc");if(c&&u){if(this.prev<a.catchLoc)return o(a.catchLoc,!0);if(this.prev<a.finallyLoc)return o(a.finallyLoc)}else if(c){if(this.prev<a.catchLoc)return o(a.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return o(a.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=t,a.arg=e,i?(this.method="next",this.next=i.finallyLoc,d):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),d},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),L(r),d}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var o=n.arg;L(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:k(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=e),d}},t}(t.exports);try{regeneratorRuntime=n}catch(t){Function("r","regeneratorRuntime = r")(n)}}});