<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Employee;

class employee_id implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!empty($value)) {
            try {
                $cek = Employee::find($value)->count();
                if ($cek<1) {
                    $fail('The :employee_id not found.');
                }
            } catch (\Throwable $th) {
                $fail('The :employee_id not found.');
            }
        }
    }
}
