<?php declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\GitHubClient as GitHubClientContract;
use Illuminate\Support\Collection;

class GitHubClient extends AbstractHttpClient implements GitHubClientContract
{
    public function fetchRepositories(): Collection
    {
        $response = $this->get('search/repositories', [
            'q' => 'stars:>1000 language:PHP NOT framework composer in:readme archived:false',
            'sort' => 'stars',
            'order' => 'desc'
        ]);
dd($response);
        return collect(array_get($response, 'items', []));
    }

    protected function options(array $data = []): array
    {
        return array_merge($data, [
            'base_uri' => config('app.services.github'),
            'timeout' => config('app.http_client_timeout'),
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }
}
