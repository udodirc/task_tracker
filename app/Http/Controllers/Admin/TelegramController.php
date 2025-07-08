<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    protected TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle(Request $request, string $token): JsonResponse
    {
        $data = $request->all();
        $chatId = data_get($data, 'message.chat.id');
        $message = data_get($data, 'message.text');

        $resonse = $this->telegram->sendMessage($chatId, $message);

        return response()->json($resonse);
    }
}
