<?php declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

abstract class AbstractHttpClient
{
    /** @var Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function get(string $urn, array $data = []): array
    {
        try {
            $response = $this->client->get($urn, $this->options(['query' => $data]));
            return $this->extractResponseBody($response);
        } catch (Throwable $exception) {
            return [];
        }
    }

    protected function extractResponseBody(ResponseInterface $response): array
    {
        $status = $response->getStatusCode();

        if ($status < 200 || $status >= 300) { // Accept only http 2xx success codes
            throw new RuntimeException('There was a problem reading data from the API.', $status);
        }

        return (array) json_decode($response->getBody()->getContents(), true);
    }

    abstract protected function options(array $data = []): array;
}
