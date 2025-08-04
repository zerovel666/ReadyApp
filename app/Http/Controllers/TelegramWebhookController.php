<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramWebhookController extends Controller
{
    private $token;
    private $uri;

    public function __construct()
    {
        $this->token = config('services.telegram.token');
        $this->uri = "https://api.telegram.org/bot{$this->token}";
    }

    public function webhook(Request $request)
    {
        $data = $request->all();

        $message = $data['message']['text'] ?? null;
        $chatId  = $data['message']['chat']['id'] ?? null;

        if ($chatId && $message) {
            $implArr = [
                "/start" => fn() => $this->start($chatId),
                "/auth" => fn() => $this->auth($chatId),
            ];

            if (isset($implArr[$message])) {
                $implArr[$message]();
            } else {
                $body = [
                    'chat_id' => $chatId,
                    'text' => "Select action undefiend",
                ];

                $this->send($body);
            }
        }

        return response('ok');
    }

    private function start($chatId)
    {
        $body = [
            'chat_id' => $chatId,
            'text' => "Select action:",
            'reply_markup' => json_encode([
                'keyboard' => [
                    ['Auth', 'Register']
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => false
            ])
        ];

        $this->send($body);
    }

    private function auth($chatId)
    {
        $body = [
            'chat_id' => $chatId,
            'text' => "Select action:",
        ];
        $this->send($body);
    }

    public function send($body)
    {
        Http::post("{$this->uri}/sendMessage", $body);
    }

    private function login($chatId, $email)
    {
        $class = app()->make(AuthService::class);
        $attribute = [
            "telegram_chat_id" => $chatId,
            "email" => $email
        ];

        $result = $class->login($attribute);

        $body = [
            'chat_id' => $chatId,
            'text' => $result['message'],
        ];

        $this->send($body);
    }
}
