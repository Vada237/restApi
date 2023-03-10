<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'login' => 'required|min:6',
            'password' => 'required|min:8',
            'pin_code' => 'required|integer|gte:10000|lte:99999',
            'role_id' => 'required'
        ];
    }
}
