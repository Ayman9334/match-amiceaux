<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMatchRequest extends FormRequest
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
        $matchMinDate = Carbon::now()->addDays(4)->format('Y-m-d H:i');
        return [
            "match_date" => "required|date_format:Y-m-d H:i|after_or_equal:$matchMinDate",
            "nembre_joueur" => "required|numeric|min:5|max:12",
            "lieu" => "required|max:150",
            "lieu2" => "max:150",
            "images" => "array",
            "images.*" => "mimes:jpg,png,jpeg|max:2500",
            "latitude" => "required",
            "longitude" => "required",
            "niveau" => [
                "required",
                Rule::exists("type_enums_details", "code")
                    ->where("type_enum_id", 2),
            ],
            "categorie" => [
                "required",
                Rule::exists("type_enums_details", "code")
                    ->where("type_enum_id", 1),
            ],
            "ligue" => [
                "required",
                Rule::exists("type_enums_details", "code")
                    ->where("type_enum_id", 4),
            ],
            "description" => "required|min:30|max:1500"
        ];
    }

    public function messages()
    {
        $matchMinDate = Carbon::now()->addDays(4)->format('d/m/Y H:i');
        return [
            "match_date.required" => "La date et l'heure du match sont obligatoires.",
            "match_date.date_format" => "Le format de la date et de l'heure doit être :format.",
            "match_date.after_or_equal" => "La date et l'heure du match doivent être aprés le $matchMinDate.",

            "nembre_joueur.required" => "Le nombre de joueurs est obligatoire.",
            "nembre_joueur.numeric" => "Le nombre de joueurs doit être un nombre.",
            "nembre_joueur.min" => "Le nombre de joueurs doit être supérieur ou égal à :min.",
            "nembre_joueur.max" => "Le nombre de joueurs ne doit pas dépasser :max.",

            "lieu.required" => "Le lieu du match est obligatoire.",
            "lieu.max" => "Le lieu du match ne doit pas dépasser :max caractères.",

            "lieu2.max" => "Le champ Lieu 2 ne doit pas dépasser :max caractères.",

            'images.array' => '',
            'images.*.mimes' => 'Chaque images doit être un fichier de type JPG, PNG ou JPEG.',
            'images.*.max' => 'Chaque image ne doit pas dépasser (2,5 Mo).',

            "latitude.required" => "La latitude est obligatoire.",
            "longitude.required" => "La longitude est obligatoire.",

            'niveau.required' => "Le niveau du match est obligatoire.",
            'niveau.exists' => "Le niveau du match sélectionné est invalide.",

            'categorie.required' => "La catégorie du match est obligatoire.",
            'categorie.exists' => "La catégorie du match sélectionnée est invalide.",

            'ligue.required' => "La ligue du match est obligatoire.",
            'ligue.exists' => "La ligue du match sélectionnée est invalide.",

            "description.required" => "La description du match est obligatoire.",
            "description.min" => "La description du match doit comporter au moins :min caractères.",
            "description.max" => "La description du match ne doit pas dépasser :max caractères."
        ];
    }
}
