<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Service\ChangeTweetsToUpperCaseService;

class GetTweetConverterUseCase
{
    private ChangeTweetsToUpperCaseService $changeTweetsToUpperCaseService;

    public function __construct(
        ChangeTweetsToUpperCaseService $changeTweetsToUpperCaseService
    ) {
        $this->changeTweetsToUpperCaseService = $changeTweetsToUpperCaseService;
    }

    public function execute(string $userName, int $limit): array
    {
        return $this->changeTweetsToUpperCaseService->execute(
            $userName,
            $limit
        );
    }
}