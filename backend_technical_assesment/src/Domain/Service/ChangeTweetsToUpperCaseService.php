<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Tweet;
use App\Infrastructure\Repository\TweetRepositoryInMemory;

class ChangeTweetsToUpperCaseService
{
    private TweetRepositoryInMemory $tweetRepositoryInMemory;
    private AssertUserNameHasValidFormatService $assertUserNameHasValidFormatService;

    public function __construct(
        TweetRepositoryInMemory $tweetRepositoryInMemory,
        AssertUserNameHasValidFormatService $assertUserNameHasValidFormatService
    ) {
        $this->tweetRepositoryInMemory = $tweetRepositoryInMemory;
        $this->assertUserNameHasValidFormatService = $assertUserNameHasValidFormatService;
    }

    /**
     * @param string $userName
     * @param int $limit
     *
     * @return string[]
     */
    public function execute(string $userName, int $limit): array
    {
        $this->assertUserNameHasValidFormatService->assert($userName);

        $tweetList = $this->tweetRepositoryInMemory->searchByUserName(
            $userName,
            $limit
        );

        return array_map(function (Tweet $tweet) {
            return strtoupper($tweet->getText());
        }, $tweetList);
    }
}