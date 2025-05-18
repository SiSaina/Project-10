<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:1000'],
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'offer_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0']
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'category_id' => $this->categoryId,
            'offer_price' => $this->offerPrice
        ]);
    }
}
