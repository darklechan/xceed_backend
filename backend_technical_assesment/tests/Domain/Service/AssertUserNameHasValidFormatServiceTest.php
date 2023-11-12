<?php

declare(strict_types=1);

namespace App\Tests\Domain\Service;

use App\Domain\Exception\InvalidUserNameException;
use App\Domain\Service\AssertUserNameHasValidFormatService;
use PHPUnit\Framework\TestCase;

class AssertUserNameHasValidFormatServiceTest extends TestCase
{
    private AssertUserNameHasValidFormatService $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new AssertUserNameHasValidFormatService();
    }

    public function test_when_user_name_is_string_number_should_throw_exception(): void
    {
        $userName = '123';

        $this->expectException(InvalidUserNameException::class);
        $this->expectExceptionMessage('Invalid user name: ' . $userName);

        $this->sut->assert($userName);
    }

    public function test_when_user_name_is_invalid_should_throw_exception(): void
    {
        $userName = 'LO-LA';

        $this->expectException(InvalidUserNameException::class);
        $this->expectExceptionMessage('Invalid user name: ' . $userName);

        $this->sut->assert($userName);
    }

    public function test_when_user_name_has_empty_spaces_should_throw_exception(): void
    {
        $userName = 'LO LA';

        $this->expectException(InvalidUserNameException::class);
        $this->expectExceptionMessage('Invalid user name: ' . $userName);

        $this->sut->assert($userName);
    }
}
