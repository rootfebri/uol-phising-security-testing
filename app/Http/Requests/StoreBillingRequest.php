<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class StoreBillingRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'birthdate' => ['required', 'string', 'max:10', $this->validateBirthday()],
            'phone' => 'required|string|max:15',
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
            'cep.required' => 'O campo CEP é obrigatório.',
            'street.required' => 'O campo rua é obrigatório.',
            'number.required' => 'O campo número é obrigatório.',
            'neighborhood.required' => 'O campo bairro é obrigatório.',
            'city.required' => 'O campo cidade é obrigatório.',
            'state.required' => 'O campo estado é obrigatório.',
        ];
    }
}
