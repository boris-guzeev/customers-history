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

    public function list()
    {
        $orders = Order::all();
        return view('orders.index', ['orders' => $orders]);
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

    public function demoCreate()
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

    public function demoUpdate()
    {
        $order = Order::where('name', '=', 'Log Test')->get()->random();
        $order->name = 'Log Test Changed';

        if ($order->save()) echo "<script>window.close();</script>";
    }

    public function demoDelete()
    {
        $order = Order::where('name', '=', 'Log Test')->get()->random();

        if ($order->delete()) echo "<script>window.close();</script>";
    }



    public function show(Order $order)
    {
        return $order;
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);

        return view('orders.edit', ['order' => $order]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'client_type' => 'required',
            'inn' => 'numeric|required_if:client_type,==,юр. лицо',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required|required_if:delivery_type,==,доставка'
        ]);


        $order->name = request('name');
        $order->email = request('email');
        $order->phone = request('phone');
        $order->phone2 = request('phone2');

        $order->save();

        return redirect('/orders');
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_type' => 'required',
            'inn' => 'numeric|required_if:client_type,==,юр. лицо',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required|required_if:delivery_type,==,доставка'
        ]);

        Order::create(request(['name', 'email', 'phone', 'phone2', 'client_type', 'inn']));

        return redirect('/orders');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect('/orders/list');
    }

}