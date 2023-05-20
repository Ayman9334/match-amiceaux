<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubRequest extends FormRequest
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
            "nom_club" => "required|string|min:5|max:50"
        ];
    }
    public function messages()
    {
        return [
            "nom_club.required" => "Le nom du club est requis.",
            "nom_club.string" => "Le nom du club doit être une chaîne de caractères.",
            "nom_club.min" => "Le nom du club doit contenir au moins :min caractères.",
            "nom_club.max" => "Le nom du club ne peut pas dépasser :max caractères.",
        ];
    }
}
