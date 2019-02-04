<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
    <body>
        <h2>Тестовое задание 1</h2>
        <p>
            Для влючения возможности Автологирования воспользуйтесь классом <strong>\App\AutologModel</strong><br><br>
            Для проверки можно быстро выполнить действия с заказами:
            <ul>
                <li><a target="_blank" href="/orders/demoCreate">Создать случайный заказ</a></li>
                <li><a target="_blank" href="/orders/demoUpdate">Отредактировать случайный заказ</a></li>
                <li><a target="_blank" href="/orders/demoDelete">Удалить случайный заказ</a></li>
            </ul>
        </p>

        <h2>Тестовое задание 2</h2>
        <p>
            Функция <strong>Order::getCustomerHistory()</strong> возвращает историю заказов клиента<br>
            Примеры выполнения:
            <ul>
                <li><a target="_blank" href="/orders/list">Таблица заказов</a></li>
                <li><a target="_blank" href="/orders/history?phone=9501112211">Найти заказы где есть телефон 9501112211</a></li>
                <li><a target="_blank" href="/orders/history?phone=9501112211&inn=1000000001">Найти заказы где есть телефон 9501112211 и ИНН 1000000001</a></li>
            <li><a target="_blank" href="/orders/history?phone=9501112211&inn=1000000001&idsOnly=true">Найти заказы где есть телефон 9501112211 и ИНН 1000000001. Вернуть только id заказа</a></li>
            </ul>
        </p>
    </body>
</html>