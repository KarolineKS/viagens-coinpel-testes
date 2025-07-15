<?php

namespace App\Rules;

use App\Models\Driver;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class CnhIsNotExpired implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * Validates that the driver's CNH (Brazilian driver's license) is not expired.
     * 
     * @param  string  $attribute  The attribute name being validated (e.g., 'driver_id')
     * @param  mixed   $value      The driver ID value to validate
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
+ * @return void
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value) || $value <= 0) {
            return;
        }

        $driver = Driver::find($value);

        if (!$driver) {
            return;
        }

        try {
            if ($driver->isCnhExpired()) {
                $fail('A CNH do motorista selecionado está vencida.');
            }
        } catch (\Exception $e) {

            Log::error('Error checking CNH expiration: ' . $e->getMessage());
            $fail('Erro ao validar CNH do motorista.');
        }
    }
}
