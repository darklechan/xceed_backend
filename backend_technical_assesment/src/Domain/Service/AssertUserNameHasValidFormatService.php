<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Exception\InvalidUserNameException;

class AssertUserNameHasValidFormatService
{
    private const USER_NAME_PATTERN = '[^([a-zA-Z])+$]';

    /**
     * @throws InvalidUserNameException
     */
    public function assert(string $userName): void
    {
        if (!preg_match(self::USER_NAME_PATTERN, $userName)) {
            throw new InvalidUserNameException('Invalid user name: ' . $userName);
        }
    }
}