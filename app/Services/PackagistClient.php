<?php declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\PackagistClient as PackagistClientContract;
use Illuminate\Support\Collection;

class PackagistClient extends AbstractHttpClient implements PackagistClientContract
{
    public function fetchLibraryList(): Collection
    {
        $response = $this->get('list.json', ['type' => 'library']);
        $libraries = array_get($response, 'packageNames', []);

        return collect($libraries);
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
