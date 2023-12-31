<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "name" => "required|unique:products,name," . $this->id,
            "price" => "required|numeric|max:999999",
            "description" => "required",
            "nutrition_detail" => "required",
            "image" => "mimes:png,jpg",
            "category_id" => "required",
            "weights" => "required",
            "discount" => "numeric|min:0|max:100"
        ];
    }
}
