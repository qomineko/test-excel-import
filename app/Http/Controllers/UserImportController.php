<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserImportRequest;
use App\Jobs\ImportUserJob;
use Illuminate\Http\JsonResponse;
use Str;
use Throwable;

final class UserImportController extends Controller
{
    /**
     * @param UserImportRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function __invoke(UserImportRequest $request): JsonResponse
    {
        $importId = Str::uuid()->toString();

        $storedPath = $request->file('file')->storeAs(
            'imports',
            $importId . '.xlsx',
            'local'
        );

        ImportUserJob::dispatch($storedPath, $importId);

        return response()->json([
            'message' => 'Файл принят в обработку',
            'import_id' => $importId,
        ]);
    }
}
