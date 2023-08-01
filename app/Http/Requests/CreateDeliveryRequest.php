<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'delivery_date' => 'required|date|after:tomorrow',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'status' => 'required|string|in:новый,доставлен,отменён',
        ];
    }
}
