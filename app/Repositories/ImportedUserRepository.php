<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\Imports\UserImport\ImportedUserRow;
use App\Models\ImportedUser;
use Illuminate\Support\Collection;

final class ImportedUserRepository
{
    /**
     * @param ImportedUserRow[] $rows
     * @return void
     */
    public function storeBatch(array $rows): void
    {
        $now = now();

        $data = array_map(fn(ImportedUserRow $row) => [
            'external_id' => $row->id,
            'name' => $row->name,
            'date' => $row->date->format('Y-m-d'),
            'created_at' => $now,
            'updated_at' => $now,
        ], $rows);

        ImportedUser::insert($data);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return ImportedUser::query()
            ->get()
            ->groupBy(fn(ImportedUser $record) => $record->date->format('Y-m-d'))
            ->map(fn(Collection $records, $date) => [
                'date' => $date,
                'items' => $records->values(),
            ])
            ->values();
    }
}
