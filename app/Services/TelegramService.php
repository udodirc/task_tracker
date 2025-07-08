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

    public function sendMessage(mixed $message): mixed
    {
        $url = config('telegram.url') . config('telegram.token') . "/sendMessage";

        try {
            $response = $this->client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'chat_id' => config('telegram.chat_id'),
                    'text' => $message,
                    'parse_mode' => 'HTML', // если нужно
                ],
                'verify' => false,
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error("Telegram sendMessage error: ".$e->getMessage());

            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
