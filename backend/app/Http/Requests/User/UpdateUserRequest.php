<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests
 *
 * @property string $name
 * @property string $email
 * @property string $password
 */
class UpdateUserRequest extends FormRequest
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

            'name' => ['required'],

            'email' => ['required', 'unique:users,email,'.$this->id],

            'role_id' => ['required'],

            'code' => ['required', 'unique:users,code,'.$this->id],

            'address' => ['required'],

            'gender' => ['required'],

            'join_date' => ['required'],

            'base_salary' => ['required'],

            'bank' => ['required'],

            'bank_account' => ['required'],
        ];
    }

    /**
     * @throws HttpResponseException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
