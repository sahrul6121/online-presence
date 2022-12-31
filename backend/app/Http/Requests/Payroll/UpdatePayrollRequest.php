<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePayrollRequest extends FormRequest
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
    * @return array<string, mixed>
    */
   public function rules()
   {
      return [
          'id' => ['required'],
          'user_id' => ['required'],
          'date' => ['required'],
          'sub_total' => ['required'],
          'tax' => ['required'],
          'total' => ['required'],
          'company' => ['required'],
          'company_address' => ['required'],
          'company_phone' => ['required'],
          'bank' => ['required'],
          'bank_account' => ['required'],
          'country' => ['required'],
          'items' => ['required']
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
