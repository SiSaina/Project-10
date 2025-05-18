<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderDetailRequest extends FormRequest
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
                'user_id' => ['required', 'integer' ,'exists:users,id'],
                'order_id' => ['required', 'integer' ,'exists:orders,id'],
                'address_id' => ['required', 'integer' ,'exists:addresses,id'],
                'status' => ['required', 'integer' , Rule::in(['pending', 'paid', 'canceled'])],
                'price' => ['required', 'numeric' ,'min:0'],
            ];
        }
        else {
            return [
                'user_id' => ['sometimes', 'required', 'integer' ,'exists:users,id'],
                'order_id' => ['sometimes', 'required', 'integer' ,'exists:orders,id'],
                'address_id' => ['sometimes', 'required', 'integer' ,'exists:addresses,id'],
                'status' => ['sometimes', 'required', 'integer' , Rule::in(['pending', 'paid', 'canceled'])],
                'price' => ['sometimes', 'required', 'numeric' ,'min:0'],
            ];
        }
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
