<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:60|unique:users',
            'email' => "required|string|min:2|max:100|email:rfc|unique:users",
            'phone' => "required|string|regex:/^[\+]{0,1}380([0-9]{9})$/|unique:users",
            'position_id' => 'required|integer|min:1',
            'photo' => 'required|image|mimes:jpg,jpeg|dimensions:min_width=70,min_height=70|max:5120',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'message' => 'Validation failed',
                    'fails' => $validator->errors()
                ],
                422
            ),

        );
    }
}
