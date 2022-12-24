<?php

namespace App\Http\Requests\Attendace;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAttendanceRequest
 * @package App\Http\Requests
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date_in
 * @property string $note
 * @property string $status
 */
class CreateAttendanceRequest extends FormRequest
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

            'note' => [],

            'status' => ['required', 'in:ON_TIME,LATE'],

        ];
    }
}
