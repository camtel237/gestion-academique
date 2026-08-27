<?php
// app/Support/CodeGenerator.php
//
// Génère des codes séquentiels uniformes du type PREFIX + numéro sur 3 chiffres
// (DEP001, SPE001, NIV001, MAT001, UE001 ...), en se basant sur le plus grand
// numéro déjà utilisé pour ce préfixe (et pas sur un simple count(), pour éviter
// les collisions après une suppression).

namespace App\Support;

class CodeGenerator
{
    /**
     * @param string $prefix Ex: 'DEP', 'SPE', 'NIV', 'MAT', 'UE'
     * @param string $modelClass Ex: \App\Models\Etablissement\Departement::class
     * @param string $column Colonne contenant le code (par défaut 'code')
     * @param int $padding Nombre de chiffres du numéro (par défaut 3 -> 001)
     */
    public static function generate(string $prefix, string $modelClass, string $column = 'code', int $padding = 3): string
    {
        $prefix = strtoupper($prefix);

        $dernierNumero = $modelClass::where($column, 'like', $prefix . '%')
            ->pluck($column)
            ->map(function ($code) use ($prefix) {
                $numero = (int) preg_replace('/^' . preg_quote($prefix, '/') . '/', '', $code);
                return $numero;
            })
            ->max();

        $prochainNumero = ($dernierNumero ?? 0) + 1;

        $code = $prefix . str_pad((string) $prochainNumero, $padding, '0', STR_PAD_LEFT);

        // Sécurité supplémentaire en cas de code déjà pris (ex: saisi manuellement avant migration)
        while ($modelClass::where($column, $code)->exists()) {
            $prochainNumero++;
            $code = $prefix . str_pad((string) $prochainNumero, $padding, '0', STR_PAD_LEFT);
        }

        return $code;
    }
}
