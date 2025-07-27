<?php

namespace App\Repositories\Vote;

use App\Models\PollVote;
use App\Repositories\BaseRepository;

class VoteRepository extends BaseRepository implements VoteRepositoryInterface
{
    public function __construct(PollVote $model)
    {
        parent::__construct($model);
    }


    /**
     * @inheritDoc
     */
    public function hasVoted(int $pollId, int $userId): bool
    {
        return $this->model->query()
            ->where('poll_id', $pollId)
            ->where('user_id', $userId)
            ->exists();
    }


    /**
     * @inheritDoc
     */
    public function countVotesByOption(int $pollId): array
    {
        return $this->model->query()
            ->where('poll_id', $pollId)
            ->selectRaw('poll_option_id, COUNT(*) as count')
            ->groupBy('poll_option_id')
            ->pluck('count', 'poll_option_id')
            ->toArray();
    }
}
