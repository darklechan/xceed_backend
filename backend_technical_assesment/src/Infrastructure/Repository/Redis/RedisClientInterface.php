<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Redis;

use Redis;

interface RedisClientInterface
{
    public function client(): Redis;
}