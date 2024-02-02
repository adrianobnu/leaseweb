<?php

namespace App\Http\Requests;

use App\Enums\DiskType;
use Orion\Http\Requests\Request;

class AssetDiskRequest extends Request
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
            'type' => 'required|string|max:255|in:'.collect(DiskType::cases())->pluck('value')->implode(','),
        ];
    }
}
