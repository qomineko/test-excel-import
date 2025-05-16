<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedUser extends Model
{
    protected $fillable = [
        'external_id',
        'name',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
