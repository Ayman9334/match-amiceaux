<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'nom' => 'required|string|min:5|max:50',
            'email' => 'required|email|unique:users|confirmed|max:150',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'confirmed'
            ],
            'n_telephone' => [
                'required',
                'regex:/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/'
            ],
            'code_postal' => [
                'required',
                'regex:/(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?/'
            ],
            'ville' => 'required|alpha|max:50',
            'region' => [
                'required',
                Rule::exists('type_enums_details', 'code')
                    ->where('type_enum_id', 3),
            ],
            'adresse' => 'required|max:100',
            'niveau' => [
                'required',
                Rule::exists('type_enums_details', 'code')
                    ->where('type_enum_id', 2),
            ],
            'categorie' => [
                'required',
                Rule::exists('type_enums_details', 'code')
                    ->where('type_enum_id', 1),
            ],
            'league' => [
                'required',
                Rule::exists('type_enums_details', 'code')
                    ->where('type_enum_id', 4),
            ],

            'conditions' => 'boolean|accepted',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le champ nom est requis.',
            'nom.string' => 'Le champ nom doit être une chaîne de caractères.',
            'nom.min' => 'Le champ nom doit contenir au moins :min caractères.',
            'nom.max' => 'Le champ nom ne doit pas dépasser :max caractères.',
            'email.required' => 'Le champ email est requis.',
            'email.email' => 'Le champ email doit être une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'email.confirmed' => 'Les adresses email ne correspondent pas.',
            'email.max' => 'Le champ email ne doit pas dépasser :max caractères.',
            'password.required' => 'Le champ mot de passe est requis.',
            'password.string' => 'Le champ mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le champ mot de passe doit contenir au moins :min caractères.',
            'password.regex' => 'Le mot de passe doit avoir au moins un lettre majuscules ,un lettre minuscules et un chiffre .',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'n_telephone.required' => 'Le champ numéro de téléphone est requis.',
            'n_telephone.regex' => 'Entrer un numéro de téléphone français valide.',
            'code_postal.required' => 'Le champ code postal est requis.',
            'code_postal.regex' => 'Entrer un code postal français valide.',
            'ville.required' => 'Le champ ville est requis.',
            'ville.alpha' => 'Le champ ville ne doit contenir que des lettres.',
            'ville.max' => 'Le champ ville ne doit pas dépasser :max caractères.',
            'region.required' => 'Le champ région est requis.',
            'region.exists' => 'La région sélectionnée est invalide.',
            'adresse.required' => 'Le champ adresse est requis.',
            'adresse.max' => 'Le champ adresse ne doit pas dépasser :max caractères.',
            'niveau.required' => 'Le champ niveau est requis.',
            'niveau.exists' => 'Le niveau sélectionné est invalide.',
            'categorie.required' => 'Le champ catégorie est requis.',
            'categorie.exists' => 'La catégorie sélectionnée est invalide.',
            'league.required' => 'Le champ ligue est requis.',
            'league.exists' => 'La ligue sélectionnée est invalide.',
            'conditions.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
        ];
    }
}
