<?php

namespace App\Repositories\Poll;

use App\Models\Poll;
use App\Repositories\BaseRepository;

class PollRepository extends BaseRepository implements PollRepositoryInterface
{
    public function __construct(Poll $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function hasVote(string $pollId): bool
    {
        return $this->find($pollId)
            ->votes()
            ->exists();
    }
}
