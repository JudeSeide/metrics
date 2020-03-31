<?php declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\PackagistClient as PackagistClientContract;
use Illuminate\Support\Collection;

class PackagistClient extends AbstractHttpClient implements PackagistClientContract
{
    public function fetchLibraryList(): Collection
    {
        $response = $this->get('list.json', ['type' => 'library']);

        $libraries = collect(array_get($response, 'packageNames', []));
        $fallback = collect(array_get(config('resources.libraries'), 'packageNames', [])); // bypass packagist throttle

        return $libraries->isNotEmpty() ? $libraries : $fallback;
    }

    protected function options(array $data = []): array
    {
        return array_merge($data, [
            'base_uri' => config('app.services.packagist.url'),
            'timeout' => config('app.http_client_timeout'),
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }
}
