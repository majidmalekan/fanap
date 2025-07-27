<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Services\Cache\CacheContext;
use App\Traits\CacheRepositoryTrait;
use App\Traits\DBTransactionLockedTrait;
use App\Traits\TableInformationTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class BaseRepository implements BaseEloquentRepositoryInterface
{
    use TableInformationTrait, DBTransactionLockedTrait, CacheRepositoryTrait;

    /**
     * @var Model
     */
    public Model $model;

    /**
     * @var CacheContext|Application|mixed|object
     */
    public CacheContext $cache;

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
        $this->cache = app(CacheContext::class);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @param array|null $whereAttributes
     * @return bool
     */
    public function update(int $id, array $attributes, array $whereAttributes = null): bool
    {
        $this->clearCache('index');
        $this->clearCache('getAll');
        $this->clearCache('find', $id);
        return $this->model->query()
            ->where('id', $id)
            ->when($whereAttributes != null, function ($query) use ($whereAttributes) {
                $query->where($whereAttributes);
            })
            ->update($attributes);
    }

    /**
     * @param int $id
     * @param array|null $whereAttributes
     * @return Model|null
     */
    public function find(int $id,array $whereAttributes=null): ?Model
    {
        return $this->cache->remember($this->getTableName() . '_find_' . (auth()->check() ?
                request()->user()->id . $id : $id),config('constants.cache_expiration'),
            function () use ($id, $whereAttributes) {
               return $this->model
                    ->query()
                    ->with($this->model->defaultRelationsForFind)
                    ->where('id', $id)
                    ->when($whereAttributes != null, function ($query) use ($whereAttributes) {
                        $query->where($whereAttributes);
                    })
                    ->firstOrFail();
            });
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $this->clearCache('index');
        $this->clearCache('getAll');
        return $this->model
            ->query()
            ->create($attributes);
    }

    /**
     * @param int $id
     * @param array|null $whereAttributes
     * @return mixed
     */
    public function delete(int $id, array $whereAttributes = null): mixed
    {
        $this->clearCache('find', $id);
        $this->clearCache('index');
        $this->clearCache('getAll');
        return $this->model
            ->query()
            ->where('id', $id)
            ->when($whereAttributes != null, function ($query) use ($whereAttributes) {
                $query->where($whereAttributes);
            })
            ->delete();
    }

    /**
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index(Request $request, int $perPage): LengthAwarePaginator
    {
        return $this->cache->remember(
            $this->getTableName() . '_index_' . ($request->user() ? $request->user()->id : '') . $request->get('page', 1),
            config('constants.cache_expiration'),
            function () use ($request, $perPage) {
               return $this->model->query()
                    ->when($request->user(), function ($query) use ($request) {
                        $query->when($request->user()->role==UserRoleEnum::ADMIN->value, function ($query) use ($request) {
                            $query->where('user_id', $request->user()->id);
                        });
                    })
                    ->orderBy($request->get('sort', 'id'), $request->get('direction', 'DESC'))
                    ->paginate($perPage, '*', '', $request->get('page', 1));
            }
        );
    }

    /**
     * @param int $id
     * @param array $attributes
     * @param array|null $whereAttributes
     * @return Model|null
     */
    public function updateAndFetch(int $id, array $attributes,array $whereAttributes=null): ?Model
    {
        if ($this->update($id, $attributes,$whereAttributes)) {
            return $this->find($id);
        }
        return null;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }
}
