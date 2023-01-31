<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrlStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'destination' => ['required', 'string', 'url', 'max:2048'],
            'enable_tracking' => ['required', 'boolean'],
            'enforce_https' => ['required', 'boolean'],
        ];
    }

    public function prepareForValidation()
    {
        if ($this->enable_tracking == 'true' ||  $this->enable_tracking == 1) {
            $this->merge(['enable_tracking' => true]);
        } else if ($this->enable_tracking == 'false' ||  $this->enable_tracking == 0) {
            $this->merge(['enable_tracking' => false]);
        }

        if ($this->enforce_https == 'true' ||  $this->enforce_https == 1) {
            $this->merge(['enforce_https' => true]);
        } else if ($this->enforce_https == 'false' ||  $this->enforce_https == 0) {
            $this->merge(['enforce_https' => false]);
        }
    }
}
