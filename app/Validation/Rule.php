<?php

namespace App\Validation;

interface Rule
{
    public function passes(mixed $value): bool;
}
