<?php

namespace App\Http\Requests\TimeSheetActivity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class CreateTimeSheetActivityRequest
 * @package App\Http\Requests
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string $start_time
 * @property string $end_time
 */
class CreateTimeSheetActivityRequest extends FormRequest
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

            'title' => ['required'],

            'description' => ['required'],

            'start_time' => ['required'],

            'end_time' => ['required'],

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
