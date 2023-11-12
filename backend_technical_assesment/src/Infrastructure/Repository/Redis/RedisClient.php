<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Redis;

use Redis;
use RedisException;

class RedisClient implements RedisClientInterface
{
    private $redis;

    /**
     * @throws RedisException
     */
    public function __construct(
        string $host,
        int $port
    ) {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
    }

    public function client(): Redis
    {
        return $this->redis;
    }
}