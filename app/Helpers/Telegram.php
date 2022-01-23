<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram
{
    protected Http $http;
    protected $bot;
    private const url = 'https://api.telegram.org/bot';

    public function __construct(Http $http, ?string $bot = null)
    {
        $this->http = $http;
        $this->bot = $bot;
    }

    public function sendMessage($chatId, $message)
    {
        return $this->http::post(self::url . $this->bot . '/sendMessage', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html',
        ]);
    }

    public function editMessage($chatId, $message, $messageId)
    {
        return $this->http::post(self::url . $this->bot . '/editMessageText', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html',
            'message_id' => $messageId,
        ]);
    }

    public function sendDocument($chatId, $file, $replyId = null)
    {
        return $this->http::attach('document', Storage::get('/public/' . $file), 'document.jpeg')
            ->post(self::url . $this->bot . '/sendDocument', [
                'chat_id' => $chatId,
                'reply_to_message_id' => $replyId
            ]);
    }

    public function sendButtons($chatId, $message, $button)
    {
        return $this->http::post(self::url . $this->bot . '/sendMessage', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => $button,
        ]);
    }

    public function editButtons($chatId, $message, $button, $messageId)
    {
        return $this->http::post(self::url . $this->bot . '/editMessageText', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => $button,
            'message_id' => $messageId,
        ]);
    }
}
