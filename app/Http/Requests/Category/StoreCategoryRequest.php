<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            "name" => "required|unique:categories,name" ,
            "description" => "required"
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "El campo nombre es requerido" ,
            "name.unique" => "El campo ya existe",
            "description.required" => "El campo descripcion es requerido"
        ];
    }
}
