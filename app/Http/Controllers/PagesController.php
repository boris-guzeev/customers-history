<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        return view('welcome', [
            'foo' => 'bar',
            'tasks' => [
                'test_1',
                'test_2'
            ]
        ]);
    }

    public function contact()
    {
        return view('contact');
    }
}
