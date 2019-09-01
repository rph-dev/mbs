<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    protected $rules = [
        //'code_order' => 'required',
        //'code' => 'required',
        'name_th' => 'required',
        'name_en' => 'required',
        'tel' => 'required',
        'email' => 'required',
        'line' => 'required',
        'addr_text' => 'required',
        'addr_province' => 'required',
        'addr_amphur' => 'required',
        'addr_district' => 'required',
        'addr_zip_code' => 'required',
        'tax_number' => 'required',
        'detail' => 'required',
        //'color1' => 'required',
        //'color2' => 'required'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return $this->postRules();
            case 'PUT' || 'PATCH':
                return $this->putRules();
            default:
                return $this->rules;
        }
    }

    /**
     * @return array
     */
    public function postRules()
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    private function putRules()
    {
        $fieldsRemove = [];

        $rules = array_diff_key($this->rules, array_flip($fieldsRemove));

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code_order.required' => 'กรุณาระบุ :attribute',
            'code.required' => 'กรุณาระบุ :attribute',
            'name_th.required' => 'กรุณาระบุ :attribute',
            'name_en.required' => 'กรุณาระบุ :attribute',
            'tel.required' => 'กรุณาระบุ :attribute',
            'email.required' => 'กรุณาระบุ :attribute',
            'line.required' => 'กรุณาระบุ :attribute',
            'addr_text.required' => 'กรุณาระบุ :attribute',
            'addr_province.required' => 'กรุณาระบุ :attribute',
            'addr_amphur.required' => 'กรุณาระบุ :attribute',
            'addr_district.required' => 'กรุณาระบุ :attribute',
            'addr_zip_code.required' => 'กรุณาระบุ :attribute',
            'tax_number.required' => 'กรุณาระบุ :attribute',
            'detail.required' => 'กรุณาระบุ :attribute',
            'color1.required' => 'กรุณาระบุ :attribute',
            'color2.required' => 'กรุณาระบุ :attribute'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'code_order' => 'รหัสลำดับ',
            'code' => 'รหัสบริษัท',
            'name_th' => 'ชื่อ (ภาษาไทย)',
            'name_en' => 'ชื่อ (ภาษาอังกฤษ)',
            'tel' => 'เบอร์โทรศัพท์',
            'email' => 'อีเมล',
            'line' => 'Line ID',
            'addr_text' => 'ที่อยู่',
            'addr_province' => 'จังหวัด',
            'addr_amphur' => 'อำเภอ',
            'addr_district' => 'ตำบล',
            'addr_zip_code' => 'รหัสไปรษณีย์',
            'tax_number' => 'เลขประจำตัวผู้เสียภาษี',
            'detail' => 'รายละเอียดเกี่ยวกับบริษัท (ไม่บังคับ)',
            'color1' => 'แถบสี Bar 2',
            'color2' => 'แถบสี Bar 2'
        ];
    }
}
