<?php

namespace App\Providers;

use App\Repositories\BaseEloquentRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\Commission\CommissionRepository;
use App\Repositories\Commission\CommissionRepositoryInterface;
use App\Repositories\GoldRequest\GoldRequestRepository;
use App\Repositories\GoldRequest\GoldRequestRepositoryInterface;
use App\Repositories\Poll\PollRepository;
use App\Repositories\Poll\PollRepositoryInterface;
use App\Repositories\PollOption\PollOptionRepository;
use App\Repositories\PollOption\PollOptionRepositoryInterface;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Setting\SettingRepositoryInterface;
use App\Repositories\Trade\TradeRepository;
use App\Repositories\Trade\TradeRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Vote\VoteRepository;
use App\Repositories\Vote\VoteRepositoryInterface;
use App\Repositories\Wallet\WalletRepository;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Services\Cache\CacheContext;
use App\Services\Cache\DatabaseCache;
use App\Services\Cache\FileCache;
use App\Services\Cache\MemCachedCache;
use App\Services\Cache\RedisCache;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BaseEloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PollRepositoryInterface::class, PollRepository::class);
        $this->app->bind(PollOptionRepositoryInterface::class, PollOptionRepository::class);
        $this->app->bind(VoteRepositoryInterface::class, VoteRepository::class);

        $this->app->bind(CacheContext::class, function ($app) {
            $strategy = match (config('cache.default')) {
                'redis' => new RedisCache(),
                'database' => new DatabaseCache(),
                'memcached' => new MemCachedCache(),
                default => new FileCache(),
            };
            return new CacheContext($strategy);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
