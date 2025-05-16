<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\UserImport\UserExcelImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Throwable;
use Illuminate\Support\Facades\Storage;

final class ImportUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly string $filePath,
    )
    {
    }

    /**
     * @throws IOException
     * @throws Throwable
     * @throws ReaderNotOpenedException
     */
    public function handle(UserExcelImportService $importService): void
    {
        $absolutePath = Storage::disk('local')->path($this->filePath);

        $importService->handle($absolutePath);
    }
}
