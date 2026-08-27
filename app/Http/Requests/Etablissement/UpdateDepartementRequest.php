<?php

namespace App\Http\Requests\Etablissement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departement = $this->route('departement');

        return [

         

            'libelle' => [
                'required',
                'string',
                'max:100',
                Rule::unique('departements')->ignore($departement),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'chef_departement_id' => [
                'nullable',
                Rule::exists('personnels', 'id')
                    ->where(function ($query) {
                        $query->where('est_actif', true);
                    }),
            ],

            'est_actif' => [
                'boolean',
            ],

        ];
    }
}