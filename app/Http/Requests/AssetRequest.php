<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class AssetRequest extends Request
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
            'name' => 'required|string|max:255',
            'code' => 'required|integer|unique:assets',
            'price' => 'required|numeric|gt:0',
            'brand_id' => 'required|integer|exists:brands,id',
        ];
    }
}
