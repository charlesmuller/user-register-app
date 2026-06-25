<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Telefone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Verifica se existem caracteres não permitidos (ex: letras)
        // Permite apenas: números, espaços, +, -, e parênteses ()
        if (preg_match('/[^0-9\-\+\(\)\s]/', $value)) {
            $fail('O :attribute contém caracteres inválidos ou letras.');
            return;
        }

        // 2. Remove tudo que não for número para contar a quantidade real de dígitos
        $telefoneLimpo = preg_replace('/[^0-9]/', '', $value);
        $tamanho = strlen($telefoneLimpo);

        // 3. Verifica o tamanho (10 para fixo, 11 para celular)
        if ($tamanho < 10 || $tamanho > 11) {
            $fail('O :attribute deve conter 10 ou 11 dígitos, incluindo o DDD.');
            return;
        }
    }
}
