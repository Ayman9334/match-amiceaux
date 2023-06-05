<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FiltreRechercheRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "latitude" => "required|numeric",
            "longitude" => "required|numeric",
            "range" => "required|numeric",
            "niveaux" => "array",
            "categories" => "array",
            "ligues" => "array",
            "niveaux.*" => [
                Rule::exists("type_enums_details", "code")
                    ->where("type_enum_id", 2),
            ],
            "categories.*" => [
                Rule::exists("type_enums_details", "code")
                    ->where("type_enum_id", 1),
            ],
            "ligues.*" => [
                Rule::exists("type_enums_details", "code")
                    ->where("type_enum_id", 4),
            ],
        ];
    }
}
