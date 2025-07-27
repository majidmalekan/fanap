<?php

namespace App\Services;

use App\Repositories\PollOption\PollOptionRepositoryInterface;

class PollOptionService extends BaseService
{
    public function __construct(PollOptionRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param int $pollId
     * @param array $options
     * @return void
     */
    public function createBulk(int $pollId, array $options): void
    {
        $this->repository->createBulk($pollId, $options);
    }

    /**
     * @param array $pollOptionIds
     * @return void
     */
    public function deleteNotExistingIds(array $pollOptionIds): void
    {
        $this->repository->deleteNotExistingIds($pollOptionIds);
    }

    /**
     * @param int $pollId
     * @param array $options
     * @return mixed
     */
    public function updateOrCreate(int $pollId, array $options): mixed
    {
        return $this->repository->updateOrCreate($pollId,$options);
    }
}
