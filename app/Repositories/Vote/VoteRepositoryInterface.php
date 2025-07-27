<?php

namespace App\Repositories\Vote;

interface VoteRepositoryInterface
{
    /**
     * @param int $pollId
     * @param int $userId
     * @return bool
     */
    public function hasVoted(int $pollId, int $userId): bool;

    /**
     * @param int $pollId
     * @return array
     */
    public function countVotesByOption(int $pollId): array;
}
