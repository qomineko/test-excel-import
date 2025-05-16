<?php

declare(strict_types=1);

namespace App\Services\UserImport;

use App\Data\Validation\ValidationResult;
use Illuminate\Support\Facades\Validator;

final class UserRowValidator
{
    /**
     * @param array $row
     * @return ValidationResult
     */
    public function validate(array $row): ValidationResult
    {
        $data = [
            'id' => $row[0] ?? null,
            'name' => $row[1] ?? null,
            'date' => $row[2] ?? null,
        ];

        $validator = Validator::make($data, [
            'id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'date' => ['required', 'date_format:d.m.Y'],
        ]);

        return new ValidationResult(
            $validator->passes(),
            $validator->errors()->all(),
        );
    }
}
