<?php

namespace App\Http\Controllers;

use App\Helpers\Telegram;
use App\Models\Order;
use Illuminate\Http\Request;

class WebHookController extends Controller
{
    public function index(Request $request, Telegram $telegram)
    {
        $messageId = $request->input('callback_query')['message']['message_id'];
        [$public, $secretKey] = explode('|', $request->input('callback_query')['data']);
        $order = Order::where('secret_key', $secretKey)->first();

        if ((int)$public === 1){
            $reply_markup = [
                'inline_keyboard' =>
                    [
                        [
                            [
                                'text' => '✅Принять',
                                'callback_data' => '1|'.$order->secret_key,
                            ],
                            [
                                'text' => 'Отклонить',
                                'callback_data' => '0|'.$order->secret_key,
                            ],
                        ]
                    ]
            ];
        }else {
            $reply_markup = [
                'inline_keyboard' =>
                    [
                        [
                            [
                                'text' => 'Принять',
                                'callback_data' => '1|'.$order->secret_key,
                            ],
                            [
                                'text' => '✅Отклонить',
                                'callback_data' => '0|'.$order->secret_key,
                            ],
                        ]
                    ]
            ];
        }

        $order->public = $public;
        $order->save();

        $data = [
            'id' => $order->id,
            'name' => $order->name,
            'email' => $order->email,
            'product' => $order->product,
        ];

        $telegram->editButtons(env('REPORT_TELEGRAM_ID'), (string)view('site.messages.new_order', $data), $reply_markup, $messageId);
    }
}
