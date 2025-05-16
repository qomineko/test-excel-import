<?php

declare(strict_types=1);

namespace App\Services\UserImport;

use App\Data\Imports\UserImport\ImportedUserRow;
use App\Events\ImportedUserCreated;
use App\Repositories\ImportedUserRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Throwable;

final readonly class UserExcelImportService
{
    public function __construct(
        private SpoutUserExcelReader       $reader,
        private UserRowValidator           $validator,
        private RedisImportProgressTracker $progressTracker,
        private ImportedUserRepository     $repository,
        private int                        $batchSize = 5000,
    )
    {
    }

    /**
     * @param string $absoluteFilePath
     * @return string $importId
     * @throws Throwable
     * @throws IOException
     * @throws ReaderNotOpenedException
     */
    public function handle(string $absoluteFilePath): string
    {
        $importId = Str::uuid()->toString();
        $errors = [];

        $batch = [];

        foreach ($this->reader->read($absoluteFilePath) as $index => $row) {
            $this->progressTracker->increment($importId);

            $validationResult = $this->validator->validate($row);

            if (!$validationResult->isValid()) {
                $errors[] = $this->formatError($index, $validationResult->errors());
                continue;
            }

            $user = ImportedUserRow::fromArray($row);
            $batch[] = $user;

            if (count($batch) >= $this->batchSize) {
                $this->repository->storeBatch($batch);

                foreach ($batch as $u) {
                    event(new ImportedUserCreated($u));
                }

                $batch = [];
            }
        }

        if (!empty($batch)) {
            $this->repository->storeBatch($batch);

            foreach ($batch as $u) {
                event(new ImportedUserCreated($u));
            }
        }

        Storage::disk('local')
            ->put("import_results/{$importId}_result.txt", implode(PHP_EOL, $errors));

        return $importId;
    }

    /**
     * @param int $index
     * @param array $errors
     * @return string
     */
    private function formatError(int $index, array $errors): string
    {
        return ($index + 2) . ' - ' . implode(', ', $errors);
    }
}
