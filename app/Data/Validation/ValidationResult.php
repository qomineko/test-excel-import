<?php

declare(strict_types=1);

namespace App\Data\Validation;

final readonly class ValidationResult
{
    public function __construct(
        private bool  $valid,
        private array $errors,
    ) {}

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
