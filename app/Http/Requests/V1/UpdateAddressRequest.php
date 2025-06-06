<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
        if(Request()->isMethod('PUT')){
            return [
                'full_name' => ['required', 'string' ,'max:255'],
                'postal_code' => ['required', 'string' ,'max:10'],
                'area' => ['required', 'string' ,'max:255'],
                'city' => ['required', 'string' ,'max:255'],
                'state' => ['required', 'string' ,'max:255'],
                'user_id' => ['required', 'integer' ,'exists:users,id'],
            ];
        }
        else {
            return [
                'full_name' => ['sometimes', 'required', 'string' ,'max:255'],
                'postal_code' => ['sometimes', 'required', 'string' ,'max:10'],
                'area' => ['sometimes', 'required', 'string' ,'max:255'],
                'city' => ['sometimes', 'required', 'string' ,'max:255'],
                'state' => ['sometimes', 'required', 'string' ,'max:255'],
                'user_id' => ['sometimes', 'required', 'integer' ,'exists:users,id'],
            ];
        }
    }
    public function prepareForValidation()
    {
        $this->merge([
            'full_name' => $this->fullName,
            'postal_code' => $this->postalCode,
            'user_id' => $this->userId
        ]);
    }
}
