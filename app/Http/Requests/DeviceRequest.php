<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uid' => 'required',
            'app_id' => 'integer|required',
            'language' => 'required',
            'operating_system' => 'required',
            'username' => '',
            'password' => ''
        ];
    }
}
