<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'customerId' => ['required', 'integer'],
                'amount' => ['required', 'numeric'],
                'status' => ['required', Rule::in(['Bill', 'Paid', 'Void', 'bill', 'paid', 'void'])],
                'billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
                'paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'],
            ];
        } else {
            return [
                'customerId' => ['sometimes', 'required', 'integer'],
                'amount' => ['sometimes', 'required', 'numeric'],
                'status' => ['sometimes', 'required', Rule::in(['Bill', 'Paid', 'Void', 'bill', 'paid', 'void'])],
                'billedDate' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
                'paidDate' => ['sometimes', 'date_format:Y-m-d H:i:s', 'nullable'],
            ];
        }
    }
}
