<?php

namespace App\Services;

use App\Models\Poll;
use App\Repositories\Vote\VoteRepositoryInterface;

class VoteService extends BaseService
{
    public function __construct(VoteRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function userHasVoted(int $pollId, int $userId): bool
    {
        return $this->repository->hasVoted($pollId, $userId);
    }

    /**
     * @param Poll $poll
     * @param int $optionId
     * @param int $userId
     * @return mixed
     * @throws \Exception
     */
    public function vote(Poll $poll, int $optionId, int $userId): mixed
    {
        $now = now();
        if ($now->lt($poll->start_at) || $now->gt($poll->end_at)) {
            throw new \Exception("زمان رأی‌گیری به پایان رسیده یا هنوز آغاز نشده.");
        }

        if ($this->repository->hasVoted($poll->id, $userId)) {
            throw new \Exception("شما قبلاً در این نظرسنجی رأی داده‌اید.");
        }
        $inputs["poll_option_id"] = $optionId;
        $inputs["user_id"] = $userId;
        $inputs["poll_id"]=$poll->id;
       return $this->repository->create($inputs);
    }

    /**
     * @param Poll $poll
     * @return array
     */
    public function getVotePercentages(Poll $poll): array
    {
        $totalVotes = $poll->votes()->count();
        if ($totalVotes === 0) {
            return [];
        }

        $optionVotes = $this->repository->countVotesByOption($poll->id);
        $percentages = [];

        foreach ($poll->options as $option) {
            $count = $optionVotes[$option->id] ?? 0;
            $percentages[$option->id] = round(($count / $totalVotes) * 100, 1);
        }

        return $percentages;
    }
}
