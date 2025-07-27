<?php

namespace App\Repositories\PollOption;

interface PollOptionRepositoryInterface
{
    /**
     * @param int $pollId
     * @param array $options
     * @return void
     */
    public function createBulk(int $pollId, array $options): void;

    /**
     * @param array $pollOptionIds
     * @return void
     */
    public function deleteNotExistingIds(array $pollOptionIds): void;

    /**
     * @param int $pollId
     * @param array $option
     * @return mixed
     */
    public function updateOrCreate(int $pollId, array $option): mixed;

}
