<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderDetailRequest extends FormRequest
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
            'user_id' => ['required', 'integer' ,'exists:users,id'],
            'order_id' => ['required', 'integer' ,'exists:orders,id'],
            'address_id' => ['required', 'integer' ,'exists:addresses,id'],
            'status' => ['required', Rule::in(['pending', 'paid', 'canceled'])],
            'date' => ['required', 'date'],
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->userId,
            'order_id' => $this->orderId,
            'address_id' => $this->addressId
        ]);
    }
}
