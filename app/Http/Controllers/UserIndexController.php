<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ImportedUserRepository;
use Illuminate\Http\JsonResponse;

final class UserIndexController extends Controller
{
    public function __construct(
        private readonly ImportedUserRepository $repository,
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return response()->json(
            $this->repository->getAll(),
        );
    }
}
