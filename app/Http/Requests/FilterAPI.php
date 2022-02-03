<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilterAPI extends FormRequest
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
            'name' => 'max:255',
            'dept_id' => 'max:255|exists:departments,id',
            'pincode' => 'numeric',
            'date_of_joining' => 'date',
            'page' => 'required|min:1|integer',
            'eid' => 'max:255|exists:employees,id',
            'role' => 'max:' . User::MANAGER_ROLE . '|min:' . User::EMPLOYEE_ROLE,
        ];
    }

    public function failedValidation(Validator $validator)
{
   throw new HttpResponseException(response()->json([
     'success'   => false,
     'message'   => 'Validation errors',
     'error'      => $validator->errors()
   ], 400));
}
}
