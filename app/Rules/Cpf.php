<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove pontos e traços, deixando apenas números
        $cpf = preg_replace('/[^0-9]/', '', $value);

        // Verifica se tem 11 dígitos ou se é uma sequência repetida boba (ex: 111.111.111-11)
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            $fail('O :attribute informado não é um CPF válido.');
            return;
        }

        // Algoritmo matemático de validação do CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $fail('O :attribute informado não é um CPF válido.');
                return;
            }
        }
    }
}