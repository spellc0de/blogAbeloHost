<?php

namespace App\Validation;

class Validator
{
    public function __construct(private array $data)
    {
    }

    public function validate(string $field, Rule $rule, mixed $default = null): mixed
    {
        if (!array_key_exists($field, $this->data)) {
            return $default;
        }

        $value = $this->data[$field];

        return $rule->passes($value) ? $value : $default;
    }
}
