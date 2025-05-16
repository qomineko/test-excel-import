<?php

declare(strict_types=1);

namespace App\Services\UserImport;

use Illuminate\Support\Facades\Redis;

final class RedisImportProgressTracker
{
    /**
     * @param string $importId
     * @return void
     */
    public function increment(string $importId): void
    {
        Redis::incr("import:progress:$importId");
    }

    /**
     * @param string $importId
     * @return int
     */
    public function get(string $importId): int
    {
        return (int)Redis::get("import:progress:$importId");
    }
}
