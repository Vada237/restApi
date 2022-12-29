<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class order_dishesRequest extends FormRequest
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
            'order_id' => 'required',
            'dishes_id' => 'required',
            'count' => 'required',
        ];
    }
}
