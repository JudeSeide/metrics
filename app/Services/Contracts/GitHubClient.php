<?php declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface GitHubClient
{
    public function fetchRepositories(): Collection;
}
