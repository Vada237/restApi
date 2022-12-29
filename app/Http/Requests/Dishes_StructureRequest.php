<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Dishes_StructureRequest extends FormRequest
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
            "product_name" => ['required','max:30'],
            "dishes_id" => ['required']
        ];
    }
}
