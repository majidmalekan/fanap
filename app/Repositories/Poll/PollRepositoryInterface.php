<?php

namespace App\Repositories\Poll;

interface PollRepositoryInterface
{
    /**
     * @param string $pollId
     * @return bool
     */
    public function hasVote(string $pollId): bool;

}
