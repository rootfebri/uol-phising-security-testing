<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cardHolder' => 'required|string|max:255',
            'cardNumber' => ['required', 'string', 'min:13', 'max:19', function ($attribute, $value, $fail) {
                $cleanNumber = preg_replace('/\D/', '', $value);
                if (!$this->validateLuhn($cleanNumber)) {
                    $fail('O número do cartão é inválido.');
                }
            }],
            'expiryDate' => ['required', 'string', 'size:5', 'regex:/^\d{2}\/\d{2}$/', function ($attribute, $value, $fail) {
                [$month, $year] = explode('/', $value);
                $month = (int)$month;
                $year = (int)('20' . $year);

                if ($month < 1 || $month > 12) {
                    $fail('O mês da data de validade é inválido.');
                    return;
                }

                $expiryDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
                if ($expiryDate->isPast()) {
                    $fail('O cartão está vencido.');
                }
            }],
            'cvv' => ['required', 'string', 'min:3', 'max:4', 'regex:/^\d{3,4}$/', function ($attribute, $value, $fail) {
                $cardNumber = preg_replace('/\D/', '', request()->input('cardNumber', ''));
                // American Express cards should have 4-digit CVV
                if ((str_starts_with($cardNumber, '34') || str_starts_with($cardNumber, '37')) && strlen($value) !== 4) {
                    $fail('O código de segurança deve ter 4 dígitos para cartões American Express.');
                } // Other cards should have 3-digit CVV
                elseif (!str_starts_with($cardNumber, '34') && !str_starts_with($cardNumber, '37') && strlen($value) !== 3) {
                    $fail('O código de segurança deve ter 3 dígitos.');
                }
            }],
            'cpf' => ['required', 'string', 'min:11', 'max:18', /*function ($attribute, $value, $fail) {
                $cleanCpf = preg_replace('/\D/', '', $value);
                if (strlen($cleanCpf) === 11) {
                    if (!$this->validateCPF($cleanCpf)) {
                        $fail('O CPF informado é inválido.');
                    }
                } elseif (strlen($cleanCpf) === 14) {
                    if (!$this->validateCNPJ($cleanCpf)) {
                        $fail('O CNPJ informado é inválido.');
                    }
                } else {
                    $fail('O CPF/CNPJ deve ter 11 ou 14 dígitos.');
                }
            }*/],
        ];
    }

    /**
     * Validate card number using Luhn algorithm
     */
    private function validateLuhn(string $cardNumber): bool
    {
        $sum = 0;
        $alternate = false;

        for ($i = strlen($cardNumber) - 1; $i >= 0; $i--) {
            $digit = (int)$cardNumber[$i];

            if ($alternate) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit = ($digit % 10) + 1;
                }
            }

            $sum += $digit;
            $alternate = !$alternate;
        }

        return $sum % 10 === 0;
    }

    /**
     * Validate CPF
     */
    private function validateCPF(string $cpf): bool
    {
        if (preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int)$cpf[$i] * (10 - $i);
        }
        $remainder = ($sum * 10) % 11;
        if ($remainder === 10 || $remainder === 11) {
            $remainder = 0;
        }
        if ($remainder !== (int)$cpf[9]) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += (int)$cpf[$i] * (11 - $i);
        }
        $remainder = ($sum * 10) % 11;
        if ($remainder === 10 || $remainder === 11) {
            $remainder = 0;
        }

        return $remainder === (int)$cpf[10];
    }

    /**
     * Validate CNPJ
     */
    private function validateCNPJ(string $cnpj): bool
    {
        if (preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }

        $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += (int)$cnpj[$i] * $weights1[$i];
        }
        $remainder = $sum % 11;
        if ($remainder < 2) {
            $remainder = 0;
        } else {
            $remainder = 11 - $remainder;
        }
        if ($remainder !== (int)$cnpj[12]) {
            return false;
        }

        $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += (int)$cnpj[$i] * $weights2[$i];
        }
        $remainder = $sum % 11;
        if ($remainder < 2) {
            $remainder = 0;
        } else {
            $remainder = 11 - $remainder;
        }

        return $remainder === (int)$cnpj[13];
    }

    public function messages(): array
    {
        return [
            'cardHolder.required' => 'O campo nome do titular é obrigatório.',
            'cardNumber.required' => 'O campo número do cartão é obrigatório.',
            'cardNumber.min' => 'O número do cartão deve ter pelo menos :min dígitos.',
            'cardNumber.max' => 'O número do cartão deve ter no máximo :max dígitos.',
            'expiryDate.required' => 'O campo data de validade é obrigatório.',
            'expiryDate.size' => 'A data de validade deve ter 5 caracteres (MM/AA).',
            'expiryDate.regex' => 'A data de validade deve estar no formato MM/AA.',
            'cvv.required' => 'O campo código de segurança é obrigatório.',
            'cvv.min' => 'O código de segurança deve ter pelo menos :min dígitos.',
            'cvv.max' => 'O código de segurança deve ter no máximo :max dígitos.',
            'cvv.regex' => 'O código de segurança deve conter apenas números.',
            'cpf.required' => 'O campo CPF/CNPJ é obrigatório.',
            'cpf.min' => 'O CPF/CNPJ deve ter pelo menos :min caracteres.',
            'cpf.max' => 'O CPF/CNPJ deve ter no máximo :max caracteres.',
        ];
    }
}
