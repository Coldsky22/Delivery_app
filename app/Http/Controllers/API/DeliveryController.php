<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Delivery;
use App\Http\Resources\DeliveryResource;
use App\Http\Requests\CreateDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Http\TelegramNotifier;

class DeliveryController extends Controller
{
    private function notifyWithTelegram(Delivery $delivery, $action) {
        $delivery->attach(new TelegramNotifier());
        $delivery->action = $action;
        $delivery->notify();
    }

    // Конструктор контроллера. Устанавливает промежуточное ПО "auth"
    // только на методы "store", "update" и "destroy".
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update', 'destroy']);
    }

    // Метод index вызывается для отображения списка доставок.
    // Принимает на вход HTTP-запрос, в котором могут быть параметры фильтрации.
    public function index(Request $request)
    {
        // Получаем значения фильтрации из запроса.
        $cityId = $request->input('city_id');
        $deliveryDate = $request->input('delivery_date');
        $query = Delivery::query();

        // Применяем фильтры к запросу, если они заданы.
        if ($cityId) {
            $query->where('city_id', $cityId);
        }

        if ($deliveryDate) {
            $query->where('delivery_date', $deliveryDate);
        }

        // Получаем по 10 доставок на страницу.
        $deliveries = $query->paginate(10);

        return DeliveryResource::collection($deliveries);
    }

    // Метод store вызывается для создания новой доставки.
    // Принимает на вход запрос с данными доставки.
    public function store(CreateDeliveryRequest $request)
    {
        $data = $request->validated();

        $city = City::find($data['city_id']);
        if (!$city) {
            return response()->json(['error' => 'Invalid city_id'], 400);
        }

        $delivery = Delivery::create($data);

        $this->notifyWithTelegram($delivery, 'create');

        return new DeliveryResource($delivery);
    }

    // Метод update вызывается для обновления существующей доставки.
    // Принимает на вход запрос с данными доставки и ID доставки.
    public function update(UpdateDeliveryRequest $request, $id)
    {

        $data = $request->validated();

        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json(['error' => 'Delivery not found'], 404);
        }

        $city = City::find($data['city_id']);
        if (!$city) {
            return response()->json(['error' => 'Invalid city_id'], 400);
        }

        $delivery->update($data);

        $this->notifyWithTelegram($delivery, 'update');

        return new DeliveryResource($delivery);
    }

    // Метод destroy вызывается для удаления существующей доставки.
    // Принимает на вход ID доставки.
    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        if (!$delivery) {
            return response()->json(['error' => 'Delivery not found'], 404);
        }

        $delivery->delete();

        $this->notifyWithTelegram($delivery, 'delete');

        return response()->json(['message' => 'Delivery deleted successfully']);
    }
}
