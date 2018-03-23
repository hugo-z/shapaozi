<?php

namespace App\Modules\Superuser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // dd($this->user());
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:20',
            'display_name' => 'required|max:20',
            'description' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            // 'name.unique' => '该角色已经存在',
            'display_name.required' => '请填写角色名称',
            // 'display_name.unique' => '该角色名称已存在',
            'display_name.max' => '角色名称过长'
        ];
    }
}
