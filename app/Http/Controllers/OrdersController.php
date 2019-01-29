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
}