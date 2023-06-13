<?php

namespace App\Http\Requests\Submissions;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric',
            'buyer' => 'required|string|max:20',
            'receipt_id' => 'required|string|max:20',
            'items' => 'required|string',
            'buyer_email' => 'required|email',
            'note' => 'required|string|max:30',
            'city' => 'required|string|max:20',
            'phone' => 'required|numeric',
        ];
    }
}
