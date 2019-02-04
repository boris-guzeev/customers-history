@extends('layout')

@section('content')
        <h1>Все заказы</h1>

        <div class="row">
                <a href="/orders/create" class="">Создать заказ</a>
        </div>
        <div class="row">
                <table class="table table-striped">
                        <thead>
                        <tr>
                                <th>ФИО</th>
                                <th>Email</th>
                                <th>Телефон</th>
                                <th>Тип клиента</th>
                                <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                        <tr>
                                <td>{{ $order->name  }}</td>
                                <td>{{ $order->email  }}</td>
                                <td>{{ $order->phone  }}</td>
                                <td>{{ $order->client_type  }}</td>
                                <td><a href="/orders/{{$order->id}}/edit">Ред.</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                </table>
        </div>
        <ul>

            <li><a href="/orders/{{ $order->id }}/edit">{{ $order->name  }} | {{ $order->email  }}</a> --- <a href="/orders/{{  $order->id }}">Открыть</a></li>

        </ul>
@endsection