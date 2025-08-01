<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait CacheRepositoryTrait
{
    /**
     * @param $key
     * @param string $id
     */
    public function clearCache($key, $id = ''): void
    {
        if ($id != '') {
            Cache::forget($this->getTableName() . '_' . $key . '_' . (auth()->check() ? request()->user()->id . $id : $id));
        }
        Cache::forget($this->getTableName() . '_index_');
        for ($i = 1; $i <= $this->getLastPage(); $i++) {
            $newKey = $this->getTableName() . '_' . ($key == "index" ? $key : "index") . '_' . (auth()->check() ? request()->user()->id . $i : $i);
            if (Cache::has($newKey)) {
                Cache::forget($newKey);
            } else {
                break;
            }
        }
        $this->clearCacheGetAll('getAll');
        $this->clearCacheGetAll($key);
    }

    /**
     * @param string $key
     * @return void
     */
    public function clearCacheGetAll(string $key): void
    {
        Cache::forget($this->getTableName() . '_' . $key);
        if (request()->user()) {
            Cache::forget($this->getTableName() . '_' . $key . request()->user()->id);
        }
    }

    /**
     * @return void
     */
    public function clearAllCache(): void
    {
        Cache::clear();
    }
}
