<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    public function index()
    {
        // Получаем все записи городов из базы данных.
        $cities = City::all();

        // Возвращаем записи городов в формате JSON используя ресурсный класс CityResource.
        // collection используется для преобразования коллекции моделей.
        return CityResource::collection($cities);
    }
}
