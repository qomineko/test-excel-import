<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:xlsx',
                'max:10240',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Необходимо прикрепить файл.',
            'file.file' => 'Файл должен быть корректным.',
            'file.mimes' => 'Допустимы только Excel-файлы (.xlsx).',
            'file.max' => 'Файл слишком большой. Максимально допустимый размер — 10MB.',
        ];
    }
}
