<?php

namespace App\Http;
use App\Models\Delivery;

class TelegramNotifier implements Observer {

    public function __construct() {
        $this->telegram_bot_token = env('TELEGRAM_BOT_TOKEN');
        $this->chat_id = env('TELEGRAM_CHAT_ID');
    }

    public function update(Delivery $delivery) {
        $message = "";
        switch ($delivery->action) {
            case 'create':
                $message = "Доставка была создана. ID: {$delivery->id}";
                break;
            case 'update':
                $message = "Доставка изменена. ID: {$delivery->id}";
                break;
            case 'delete':
                $message = "Доставка удалена. ID: {$delivery->id}";
                break;
        }

        file_get_contents("https://api.telegram.org/bot{$this->telegram_bot_token}/sendMessage?chat_id={$this->chat_id}&text={$message}");
    }
}
