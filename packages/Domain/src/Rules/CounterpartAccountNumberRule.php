<?php

namespace Domain\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CounterpartAccountNumberRule implements ValidationRule
{
    private int $maxLength;

    public function __construct(int $maxLength = 50)
    {
        $this->maxLength = $maxLength;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || strlen($value) > $this->maxLength) {
            $fail("Pole {$attribute} musí být text o maximální délce {$this->maxLength} znaků.");
        }
    }
}


