<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\Rule;
use App\Models\Product;

class Ventas extends FormRequest
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
            "venta.cliente" => "required",
            "venta.productos" => "required",
            "venta.descuento" => "sometimes",
            'venta.productos.*.id' => [
                'required',
                'numeric',
                Rule::exists(Product::class, 'id'), // Valida que el id del producto exista en la tabla de productos
            ],
        ];
    }

    public function messages(): array
    {
        return [
            "venta.productos.*.id.exists" => "El producto seleccionado con ID :value no existe."
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(response()->json(['error' => $errors], 422));
    }
}
