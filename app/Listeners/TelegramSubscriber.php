<?php

namespace App\Listeners;

use App\Events\OrderStore;
use App\Helpers\Telegram;
use Illuminate\Events\Dispatcher;

class TelegramSubscriber
{
    protected Telegram $telegram;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(OrderStore::class, [__CLASS__, 'orderStore']);
    }

    public function orderStore($event)
    {
        $data = [
            'id' => $event->order->id,
            'name' => $event->order->name,
            'email' => $event->order->email,
            'product' => $event->order->product,
        ];

        $reply_markup = [
            'inline_keyboard' =>
                [
                    [
                        [
                            'text' => 'Принять',
                            'callback_data' => '1|'.$event->order->secret_key,
                        ],
                        [
                            'text' => 'Отклонить',
                            'callback_data' => '0|'.$event->order->secret_key,
                        ],
                    ]
                ]
        ];

        $this->telegram->sendButtons(env('REPORT_TELEGRAM_ID'), (string)view('site.messages.new_order', $data), $reply_markup);

    }

    /**
     * Handle the event.
     *
     * @param \App\Events\OrderStore $event
     * @return void
     */
    public function handle(OrderStore $event)
    {
        //
    }
}
