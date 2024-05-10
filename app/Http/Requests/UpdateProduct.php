<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:255|filled', // Añade 'sometimes' para indicar que el campo es opcional
            'description' => 'nullable|string|filled',
            'price' => 'numeric|min:0|filled', // Añade 'sometimes' para indicar que el campo es opcional
            'stock' => 'numeric|min:0|filled',
            'descuento' => 'boolean|min:0|filled',
            'image_url' => 'string|min:0|filled',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(response()->json(['error' => $errors], 422));
    }
}
