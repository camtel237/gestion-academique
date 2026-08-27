<?php
// app/Http/Requests/Etablissement/StoreSpecialiteRequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSpecialiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           
            'libelle' => [
                'required',
                'string',
                'max:100',
            ],
            'departement_id' => [
                'required',
                'exists:departements,id',
                Rule::exists('departements', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
           
            'libelle.required' => 'Le libellé est obligatoire.',
            'departement_id.required' => 'Le département est obligatoire.',
            'departement_id.exists' => 'Veuillez sélectionner un département actif.',
        ];
    }
}