<?php

namespace App\Http\Requests\Api\Modules\ComplaintModule\Complaint;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enum\ComplaintCategoryEnum;
use App\Enum\ComplaintPriorityEnum;
use App\Enum\ComplaintStatusEnum;

class CreateComplaintRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'category' => [
                'required',
                Rule::in(ComplaintCategoryEnum::all())
            ],
            'priority' => [
                'required',
                Rule::in(ComplaintPriorityEnum::all())
            ],
            'status' => [
                'required',
                Rule::in(ComplaintStatusEnum::all())
            ],
            'submission_date' => 'required|date|after_or_equal:today',
            'image' => 'file|mimes:jpg,png,jpeg,webp|max:1000'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'status' => 'error',
            'message' => 'Validation Failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
