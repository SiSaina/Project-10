<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCategoryRequest extends FormRequest
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
                'name' => ['required', 'string', 'max:255']
            ];
        }
        else {
            return [
                'name' => ['sometimes', 'required', 'string', 'max:255']
            ];
        }
    }
}
