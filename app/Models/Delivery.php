<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['city_id', 'address', 'delivery_date', 'client_name', 'client_phone', 'status'];

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // Метод findOrFail для поиска доставки по идентификатору
    public static function findOrFail($id)
    {
        $delivery = static::find($id);

        if (!$delivery) {
            throw new ModelNotFoundException("Delivery with ID {$id} not found.");
        }

        return $delivery;
    }
}
