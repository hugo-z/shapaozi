<?php

namespace App\Modules\Superuser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\cellPhone;

class StoreUser extends FormRequest
{
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
        return [
            'name' => 'required|max:20',
            'email' => 'email|unique:huge__admin',
            'cell' => ['digits:11', 'unique:huge__admin', new cellPhone],
            'country' => 'digits:6|numeric',
            'province' => 'digits:6|numeric',
            'city' => 'digits:6|numeric',
            'division' => 'digits:6|numeric'
        ];
    }
}
