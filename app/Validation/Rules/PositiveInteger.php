<?php

namespace App\Validation\Rules;

use App\Validation\Rule;

class PositiveInteger implements Rule
{
    public function passes(mixed $value): bool
    {
        return is_numeric($value) && (int) $value > 0;
    }
}
