<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function history(Request $request)
    {
        $phone = $request->input('phone');
        $email = $request->input('email');
        $inn = $request->input('inn');
        $idsOnly = $request->input('idsOnly');

        echo '<pre>';
        print_r(Order::getCustomerHistory($phone, $email, $inn, $idsOnly));
        echo '</pre>';
    }

    public function create()
    {
        $pay_type_array = ['нал', 'безнал'];
        $delivery_type_array = ['самовывоз', 'доставка'];
        $delivery_type = $delivery_type_array[rand(0, 1)];

        $order = new Order;
        $order->email = "logtest@mail.test";
        $order->name = 'Log Test';
        $order->phone =95011122 . rand(10, 99);
        $order->phone2 = 95011122 . rand(10, 99);
        $order->client_type = 'физ. лицо';
        $order->pay_type = $pay_type_array[rand(0, 1)];
        $order->delivery_type = $delivery_type;
        $order->created_at = date('Y-m-d H:i:s');

        if ($order->save()) echo "<script>window.close();</script>";
    }

    public function update()
    {
        $order = Order::where('name', '=', 'Log Test')->get()->random();
        $order->name = 'Log Test Changed';

        if ($order->save()) echo "<script>window.close();</script>";
    }

    public function delete()
    {
        $order = Order::where('name', '=', 'Log Test')->get()->random();

        if ($order->delete()) echo "<script>window.close();</script>";
    }
}