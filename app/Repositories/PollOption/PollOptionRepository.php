<?php

namespace App\Repositories\PollOption;

use App\Models\PollOption;
use App\Repositories\BaseRepository;

class PollOptionRepository extends BaseRepository implements PollOptionRepositoryInterface
{
    public function __construct(PollOption $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function createBulk(int $pollId, array $options): void
    {
        $this->clearCache('index');
        $this->clearCache('getAll');
        $bulkData = collect($options)
            ->filter(fn($text) => !empty($text))
            ->map(fn($text) => ['poll_id' => $pollId, 'text' => $text, 'created_at' => now(), 'updated_at' => now()])
            ->toArray();

        $this->model->query()->insert($bulkData);
    }

    /**
     * @inheritDoc
     */
    public function deleteNotExistingIds(array $pollOptionIds): void
    {
        $this->clearCache('index');
        $this->clearCache('getAll');
        $this->model->query()
            ->whereNotIn('id', $pollOptionIds)
            ->delete();
    }

    /**
     * @inheritDoc
     */
    public function updateOrCreate(int $pollId, array $option): mixed
    {
        $this->clearCache('find', $option['id']);
        $this->clearCache('index');
        $this->clearCache('getAll');
        return $this->model->query()->updateOrCreate(
            ['id' => $option['id'], 'poll_id' => $pollId],
            ['text' => $option['text']]
        );
    }
}
