<?php declare(strict_types=1);

namespace App\Providers;

use App\Services\Contracts\GitHubClient as GitHubClientContract;
use App\Services\Contracts\PackagistClient as PackagistClientContract;
use App\Services\GitHubClient;
use App\Services\PackagistClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Bootstrap any application services.
    }

    public function register(): void
    {
        $this->app->bind(GitHubClientContract::class, GitHubClient::class);
        $this->app->bind(PackagistClientContract::class, PackagistClient::class);
    }
}
