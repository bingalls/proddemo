<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

/**
 * @property string $name
 * @property string $description
 * @property float $price
 */
class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            '_token' => 'string|size:40',   // does not exist in CLI
            'description' => 'nullable|string|max:' . config('appfront.descMax'),
            'id' => 'integer|between:0,2147483647', // max sqlite *signed* int(10) value
            'image' => 'mimes:gif,jpg,jpeg,png|max:' . config('appfront.imgMax'),
            'name' => 'required|string|min:' . config('appfront.prodNameMin') . '|max:' . config('appfront.prodNameMax'),
            'price' => 'required|numeric|min:0|max:' . config('appfront.priceMax'),
        ];
    }
}
