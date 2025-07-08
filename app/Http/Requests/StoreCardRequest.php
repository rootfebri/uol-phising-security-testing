<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest {
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
            'cardHolder' => 'required|string|max:255',
            'cardNumber' => 'required|string|min:16|max:21',
            'expiryDate' => 'required|date_format:m/y|after:today',
            'cvv' => 'required|min:3|max:4|numeric',
            'cpf' => 'required|string|min:11',
        ];
    }

    public function messages()
    {
        return [
            'cardHolder.required' => 'Este campo é obrigatório.',
            'cardNumber.required' => 'Este campo é obrigatório.',
            'expiryDate.required' => 'Este campo é obrigatório.',
            'cvv.required' => 'Este campo é obrigatório.',
            'cpf.required' => 'Este campo é obrigatório.',
            'cardNumber.min' => 'O valor deve ter pelo menos :min caracteres.',
            'cardNumber.max' => 'O valor não pode ter mais de :max caracteres.',
            'expiryDate.date_format' => 'O formato da data é inválido. Use MM/AA.',
            'expiryDate.after' => 'A data deve estar no futuro.',
            'cvv.min' => 'O valor deve ter pelo menos :min caracteres.',
            'cvv.max' => 'O valor não pode ter mais de :max caracteres.',
        ];
    }

}
