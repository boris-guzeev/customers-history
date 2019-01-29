<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use \App\Order;

class InsertDemoInformation extends Migration
{
    private function getRandomName()
    {
        $names = [
            [
                'Михайлов', 'Иванов', 'Петров', 'Сидоров', 'Сергеев', 'Александров'
            ],
            [
                '', 'Иван', 'Пётр', 'Алексей', 'Сергей', 'Анатолий'
            ]
        ];
        $rand = rand(0, 1);
        $first = $names[$rand][rand(0, 5)];
        $last = $rand == 0 ? $names[1][rand(0, 5)] : $names[0][rand(0, 5)];

        $output = preg_replace('/^ /', '', $first . ' ' . $last);
        return preg_replace('/$ /', '', $output);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $client_type_array = ['юр. лицо', 'физ. лицо'];
        $pay_type_array = ['нал', 'безнал'];
        $delivery_type_array = ['самовывоз', 'доставка'];

        $ordersQuantity = rand(80, 150);
        $orders = [];
        for ($i = 0; $i < $ordersQuantity; $i++) {
            $delivery_type = $delivery_type_array[rand(0, 1)];
            $client_type = $client_type_array[rand(0, 1)];
            $phones = [
                9501112211,
                9501112222,
                9501112233,
                9501112244,
                9501112255,
                9501112266,
                9501112277,
                9501112288,
                9501112299,
                9501112200
            ];
            $phone = $phones[rand(0, 9)];

            $order = [
                'email' => "$phone@mail.test",
                'name' => $this->getRandomName(),
                'phone' => $phone,
                'phone2' => 95011122 . rand(10, 99),
                'client_type' => $client_type,
                'pay_type' => $pay_type_array[rand(0, 1)],
                'delivery_type' => $delivery_type,
                'created_at' => date('Y-m-d H:i:s'),
                'address' => '',
                'inn' => '',
                'delivery_date' => ''
            ];

            if ($delivery_type == 'доставка') {
                $streets = [
                    'Пл. Ленина',
                    'Героев Сибиряков',
                    'Комарова',
                    'Лизюкова',
                    'Хользунова',
                    'Проспект рев-ции'
                ];
                $address = '"' . $streets[rand(0, 5)] . ', д. ' . rand(1, 30) . ', кв. ' . rand(1, 200) . '"';

                $order['address'] = $address;

                $int = rand(time(), time() + 60 * 60 * 60);
                $order['delivery_date'] = date("Y-m-d", $int);
            }

            $inns = [
                1000000001,
                1000000002,
                1000000003,
                1000000004,
                1000000005,
                1000000006,
                1000000007,
                1000000008,
                1000000009,
                1000000010,
            ];
            $inn = $inns[rand(0, 9)];
            if ($client_type == 'юр. лицо') {
                $order['inn'] = $inn;
            }

            $orders[] = $order;
        }
        Order::insert($orders);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
