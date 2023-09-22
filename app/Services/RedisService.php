<?php

declare(strict_types=1);

namespace App\Services;

use Predis\Client;

final class RedisService
{
    public bool $isEnabled = false;

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->isEnabled = config('app.redis.enabled') === 'true';
    }

    public function has(string $key): int
    {
        return $this->client->exists($key);
    }
    public function get(string $key): string
    {
        return $this->client->get($key);
    }

    public function set(string $key, string $value): void
    {
        $this->client->set($key, $value);
    }

    public function delete(string $key): void
    {
        $this->client->del($key);
    }
}