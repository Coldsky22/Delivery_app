
## Delivery Application


## Что реализовано в проекте:

- Клиентское CRUD API для доставок с возможностью получения списка с фильтром по городам (с пагинацией).
- Админ панель со списком доставок с возможностью фильтрации по дате и городу, а также возможностью изменить статус доставки.

## Установка и использование:

### Установка:

1. Клонировать репозиторий
2. Выполнить команду `composer install`
3. Выполнить команду `npm install`
4. Выполнить команду `php artisan migrate`
5. Выполнить команду `php artisan db:seed` (Это наполнит базу данных тестовыми данными, создаст двух пользователей - администратора и обычного пользователя. После этого вы сможете войти в админ панель.)

### Использование API с помощью Postman:

1. Запустить сервер с помощью команды `php artisan serve`
2. Отправить GET-запрос на роут `http://127.0.0.1:8000/sanctum/csrf-cookie` через Postman (Не забудьте указать `Accept application/json` в заголовках запроса, а так же заголовок Referer 127.0.0.1)
3. Скопировать полученный cookie без окончания `%3d`
4. Отправить POST-запрос на роут `http://127.0.0.1:8000/login` с данными пользователя (email = `user@mail.ru`, password = `123123123`). В заголовках запроса включите `X-XSRF-TOKEN` и `Accept` из предыдущего шага, а также заголовок `Content-Type: application-json`.
5. После этого вы получите доступ к следующим маршрутам:
    - GET `http://127.0.0.1:8000/api/cities`

**Пример ответа:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Jerdeland"
    },
    {
      "id": 2,
      "name": "Lake Dino"
    }
  ]
}
```
- GET `http://127.0.0.1:8000/api/deliveries` 

Возможные параметры фильтрации: 
- delivery_date (Тип: string, Формат: 'YYYY-MM-DD') 
- city_id (Тип: number)

Примеры фильтрации:

`http://127.0.0.1:8000/api/deliveries?delivery_date=2023-07-27`
`http://127.0.0.1:8000/api/deliveries?city_id=11` 


**Пример ответа:** 
```json{
{
  "data": [
    {
      "id": 1,
      "city_id": 11,
      "address": "84827 Yost Vista\nSouth Maegan, OR 59573",
      "delivery_date": "2023-07-27",
      "client_name": "Linnie Wiegand III",
      "client_phone": "+1-283-555-9135",
      "status": "доставлен",
      "created_at": "2023-07-24T22:18:56.000000Z",
      "updated_at": "2023-07-24T22:18:56.000000Z"
    }
  ]
}
```
- POST `http://127.0.0.1:8000/api/deliveries`

**Пример payload:**
```json{
{
  "city_id": 11,
  "address": "Биг монета",
  "delivery_date": "2023-08-04",
  "client_name": "Linnie Wiegand III",
  "client_phone": "+1-283-555-9135",
  "status": "новый"
}
 ```
- PUT `http://127.0.0.1:8000/api/deliveries/{id}` 

**Пример payload:** 
```json{
{
  "city_id": 11,
  "address": "Биг монета",
  "delivery_date": "2023-08-04",
  "client_name": "Linnie Wiegand III",
  "client_phone": "+1-283-555-9135",
  "status": "доставлен"
}
```
   
- DELETE `http://127.0.0.1:8000/api/deliveries/{id}`


### Использование Админ панели:

1. Запустить сервер с помощью команды `php artisan serve`
2. Запустить сборку ассетов с помощью команды `npm run dev`
3. Открыть в браузере роут `http://127.0.0.1:8000/login` и заполнить форму с данными для входа (admin@admin.com, admin)
4. Перейти на роут `http://127.0.0.1:8000/admin`. Здесь вы можете менять статус доставки и применять фильтр по городам и дате.
