<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
                'product_id' => ['required', 'integer', 'exists:products,id'],
                'quantity' => ['required', 'integer', 'min:1'],
            ];
        }
        else {
            return [
                'product_id' => ['sometimes', 'required', 'integer', 'exists:products,id'],
                'quantity' => ['sometimes', 'required', 'integer', 'min:1'],
            ];
        }
    }
    public function prepareForValidation()
    {
        $this->merge([
            'product_id' => $this->productId
        ]);
    }
}
