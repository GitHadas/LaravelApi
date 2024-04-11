<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
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
        $method = $this->method();

        if($method == 'PUT'){
            return [
                'customerId'=> ['required'],
                'amount'=> ['required'],
                'status'=> ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])],
                'billedDate'=> ['required'],
                'paidDate'=> []
            ];
        }
        return [
            'customerId'=> ['sometimes', 'required'],
            'amount'=> ['sometimes', 'required'],
            'status'=> ['sometimes', 'required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])],
            'billedDate'=> ['sometimes', 'required'],
            'paidDate'=> ['sometimes', 'required']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'customer_id' => $this->customerId ?: null,
            'billed_date' => $this->billedDate ?: null,
            'paid_date' => $this->paidDate ?: null,
        ]);
    }
}