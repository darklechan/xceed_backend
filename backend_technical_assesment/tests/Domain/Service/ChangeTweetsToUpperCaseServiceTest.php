<?php

declare(strict_types=1);

namespace App\Tests\Domain\Service;

use App\Domain\Entity\Tweet;
use App\Domain\Exception\InvalidUserNameException;
use App\Domain\Service\AssertUserNameHasValidFormatService;
use App\Domain\Service\ChangeTweetsToUpperCaseService;
use App\Infrastructure\Repository\TweetRepositoryInMemory;
use PHPUnit\Framework\TestCase;

class ChangeTweetsToUpperCaseServiceTest extends TestCase
{
    private ChangeTweetsToUpperCaseService $sut;
    private $repository;
    private $assertUserNameHasValidFormatService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(TweetRepositoryInMemory::class);
        $this->assertUserNameHasValidFormatService = $this->createMock(AssertUserNameHasValidFormatService::class);

        $this->sut = new ChangeTweetsToUpperCaseService(
            $this->repository,
            $this->assertUserNameHasValidFormatService
        );
    }

    public function test_when_user_name_is_invalid_should_throw_exception(): void
    {
        $userName = 'Lo-la';
        $limit = 2;

        $this->expectException(InvalidUserNameException::class);
        $this->expectExceptionMessage('Invalid user name: ' . $userName);

        $this->assertUserNameHasValidFormatService
            ->expects(self::once())
            ->method('assert')
            ->with($userName)
            ->willThrowException(new InvalidUserNameException('Invalid user name: ' . $userName));

        $this->repository
            ->expects(self::never())
            ->method('searchByUserName');

        $this->sut->execute($userName, $limit);
    }

    public function test_get_tweets_in_upper_case(): void
    {
        $userName = 'Lola';
        $limit = 2;

        $tweetList = [
            new Tweet('hola'),
            new Tweet('xceed'),
        ];

        $this->assertUserNameHasValidFormatService
            ->expects(self::once())
            ->method('assert')
            ->with($userName);

        $this->repository
            ->expects(self::once())
            ->method('searchByUserName')
            ->with($userName, $limit)
            ->willReturn($tweetList);

        $expectedResult = ['HOLA', 'XCEED'];

        $actualResult = $this->sut->execute('Lola', 2);

        self::assertEquals($expectedResult, $actualResult);
    }
}
