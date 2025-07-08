<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendMessage(mixed $chatID, mixed $message): mixed
    {
        $url = config('telegram.url').config('telegram.token')."/sendMessage";

        $response = $this->client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'chat_id' => $chatID,
                'text' => $message,
            ],
            'verify' => false,
        ]);

        return json_decode($response->getBody(), true);
    }
}
