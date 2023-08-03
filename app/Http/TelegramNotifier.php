<?php

namespace App\Http;
use App\Models\Delivery;

class TelegramNotifier {

    public function __construct() {
        $this->telegram_bot_token = env('TELEGRAM_BOT_TOKEN');
        $this->chat_id = env('TELEGRAM_CHAT_ID');
    }

    public function created(Delivery $delivery) {
        $this->sendTelegramNotification($delivery, "Доставка была создана. ID: {$delivery->id}");
    }

    public function updated(Delivery $delivery) {
        $this->sendTelegramNotification($delivery, "Доставка изменена. ID: {$delivery->id}");
    }

    public function deleted(Delivery $delivery) {
        $this->sendTelegramNotification($delivery, "Доставка удалена. ID: {$delivery->id}");
    }

    protected function sendTelegramNotification(Delivery $delivery, string $message) {
        file_get_contents("https://api.telegram.org/bot{$this->telegram_bot_token}/sendMessage?chat_id={$this->chat_id}&text={$message}");
    }
}

