<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class AssetMemoryRequest extends Request
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
    public function commonRules(): array
    {
        return [
            'size' => 'required|integer|gt:0',
            'quantity' => 'required|integer|gt:0',
        ];
    }
}
