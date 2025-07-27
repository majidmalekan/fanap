<?php

namespace App\Services;

use App\Repositories\Poll\PollRepositoryInterface;

class PollService extends BaseService
{
    public function __construct(PollRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param string $pollId
     * @return mixed
     */
    public function hasVote(string $pollId)
    {
        return $this->repository->hasVote($pollId);
    }
}
