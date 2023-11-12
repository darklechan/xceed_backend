<?php

namespace App\Domain\Repository;

interface TweetRepository
{
    public function searchByUserName(string $username, int $limit): array;
}
