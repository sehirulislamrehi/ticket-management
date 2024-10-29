<?php

namespace App\Http\Requests\Backend\Modules\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
     /**
      * Determine if the user is authorized to make this request.
      */
     public function authorize(): bool
     {
          return true;
     }

     /**
      * Get the validation rules that apply to the request.
      *
      * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
      */
     public function rules(): array
     {
          return [
               'email' => 'required|exists:users,email',
               'password' => 'required',
          ];
     }

     protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
     {
          // Override the failedValidation method to customize the response
          throw new \Illuminate\Validation\ValidationException($validator);
     }
}
