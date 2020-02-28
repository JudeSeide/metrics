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
            'order' => 'desc',
            'per_page' => 400
        ]);

        $repositories = collect(array_get($response, 'items', []));
        $fallback = collect(array_get(config('resources.repositories'), 'items', [])); // bypass github throttle

        return $repositories->count() >= 300 ? $repositories : $fallback;
    }

    protected function options(array $data = []): array
    {
        return array_merge($data, [
            'base_uri' => config('app.services.github.url'),
            'timeout' => config('app.http_client_timeout'),
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'token '.config('app.services.github.token'),
            ],
        ]);
    }
}
