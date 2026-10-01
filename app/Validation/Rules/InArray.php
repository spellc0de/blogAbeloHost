<?php

namespace App\Validation\Rules;

use App\Validation\Rule;

class InArray implements Rule
{
    public function __construct(private array $allowed)
    {
    }

    public function passes(mixed $value): bool
    {
        return in_array($value, $this->allowed, true);
    }
}
