<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Carbon\Month;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Throwable;

class StorePaymentRequest extends FormRequest {
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
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'birthdate' => ['required', 'string', 'max:10', $this->validateBirthday()],
            'phone' => 'required|string|max:15',
            'cardName' => 'required|string|max:255',
            'cardNumber' => 'required|string|max:19',
            'cardExpiry' => ['required', 'string', 'max:5', $this->validateCardExpire()],
            'cardCVC' => ['required', 'string', 'min:3', 'max:4', function ($attribute, $value, $fail) {
                $card = $this->post('cardNumber');
                if (strlen($value) !== 4 && (str_starts_with($card, '34') || str_starts_with($card, '37'))) {
                    $fail('O código de segurança do cartão é inválido.');
                }
            }],
            'cep' => 'required|string|max:11',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
        ];
    }

    private function validateBirthday(): Closure
    {
        return static function ($attribute, $value, $fail) {
            if (($date = Carbon::createFromFormat('d/m/Y', $value)) === null) {
                $fail('A data de nascimento deve estar no formato DD/MM/AAAA.');
            }

            $age = $date->diffInYears(null, true, true);
            if ($age < 12 || $age > 100 || $date->isFuture()) {
                $fail('Por favor, informe uma data de nascimento válida.');
            }
        };
    }

    private function validateCardExpire(): Closure
    {
        return static function ($attribute, $value, $fail) {
            [$month, $year] = explode('/', $value);

            try {
                $month = Month::from((int)$month);
                $carbon = Carbon::now()->setMonth($month)->setYear((int)"20$year");
                if ($carbon->isPast()) {
                    $fail('O cartão está vencido.');
                }
            } catch (Throwable) {
                $fail('O cartão está vencido.');
            }

        };
    }

    public function attributes(): array
    {
        return collect($this->all())
            ->keys()
            ->mapWithKeys(fn($key) => [$key => str($key)->kebab()->slug(' ')->title()])
            ->toArray();
    }

    public function messages(): array
    {
        return [
            '*' => 'Há erros no formulário. Corrija-os para continuar.',
            'name.required' => 'O campo nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'birthdate.required' => 'O campo data de nascimento é obrigatório.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'cardName.required' => 'O campo nome no cartão é obrigatório.',
            'cardNumber.required' => 'O campo número do cartão é obrigatório.',
            'cardExpiry.required' => 'O campo validade do cartão é obrigatório.',
            'cardCVC.required' => 'O campo código de segurança do cartão é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'street.required' => 'O campo rua é obrigatório.',
            'number.required' => 'O campo número é obrigatório.',
            'neighborhood.required' => 'O campo bairro é obrigatório.',
            'city.required' => 'O campo cidade é obrigatório.',
            'state.required' => 'O campo estado é obrigatório.',
        ];
    }
}
