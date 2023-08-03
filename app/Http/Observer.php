<?php

namespace App\Http;
use App\Models\Delivery;

interface Observer {
    public function update(Delivery $delivery);
}
