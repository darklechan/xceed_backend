<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCase;

use App\Application\UseCase\GetTweetConverterUseCase;
use App\Domain\Service\ChangeTweetsToUpperCaseService;
use PHPUnit\Framework\TestCase;

class GetTweetConverterUseCaseTest extends TestCase
{
    private GetTweetConverterUseCase $sut;
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->createMock(ChangeTweetsToUpperCaseService::class);

        $this->sut = new GetTweetConverterUseCase(
            $this->service
        );
    }

    public function test_when_data_is_retrieved_correctly(): void
    {
        $serviceDataList = ['RUBY ON RAILS'];

        $userName = 'Lola';
        $limit = 1;

        $this->service
            ->expects(self::once())
            ->method('execute')
            ->with($userName, $limit)
            ->willReturn($serviceDataList);

        $actualResponse = $this->sut->execute($userName, $limit);

        self::assertEquals($serviceDataList, $actualResponse);
    }
}
