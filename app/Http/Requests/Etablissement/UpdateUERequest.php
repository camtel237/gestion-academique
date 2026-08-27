<?php
// app/Http/Requests/Etablissement/UpdateUERequest.php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUERequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('ue');

        return [
            'libelle' => [
                'required',
                'string',
                'max:150',
            ],
            'total_credit' => [
                'required',
                'integer',
                'min:1',
                'max:60',
            ],
            'position_releve' => [
                'nullable',
                'integer',
                'min:1',
            ],
           
            'semestre_id' => [
                'required',
                'exists:semestres,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Le code est obligatoire.',
            'code.unique' => 'Ce code d\'UE existe déjà.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'total_credit.required' => 'Le total de crédits est obligatoire.',
            'total_credit.min' => 'Le total de crédits doit être au moins 1.',
            'total_credit.max' => 'Le total de crédits ne peut pas dépasser 60.',
            'semestre_id.required' => 'Le semestre est obligatoire.',
            'semestre_id.exists' => 'Veuillez sélectionner un semestre actif.',
        ];
    }
}