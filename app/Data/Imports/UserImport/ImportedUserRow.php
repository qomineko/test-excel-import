<?php

declare(strict_types=1);

namespace App\Data\Imports\UserImport;

use Illuminate\Support\Carbon;

final readonly class ImportedUserRow
{
    public function __construct(
        public int    $id,
        public string $name,
        public Carbon $date,
    )
    {
    }

    /**
     * @param array $row
     * @return self
     */
    public static function fromArray(array $row): self
    {
        return new self(
            (int)$row[0],
            (string)$row[1],
            Carbon::createFromFormat('d.m.Y', $row[2]),
        );
    }
}
