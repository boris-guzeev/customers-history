@extends('layout')

@section('content')
    <h1>Создать заказ</h1>

    <form method="POST" action="/orders">
        {{ csrf_field()  }}

        <div class="form-group">
            <label for="name">Имя:</label>
            <input class="form-control {{ $errors->has('name') ? 'alert-danger' : ''  }}" type="text" name="name" value="{{ old('name')  }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control {{ $errors->has('email') ? 'alert-danger' : ''  }}" type="text" name="email" value="{{ old('email')  }}">
        </div>

        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input class="form-control {{ $errors->has('phone') ? 'alert-danger' : ''  }}" type="text" name="phone" value="{{ old('phone')  }}">
        </div>

        <div class="form-group">
            <label for="phone2">Доп. телефон:</label>
            <input class="form-control " type="text" name="phone2" value="{{ old('phone2')  }}">
        </div>

        <div class="form-group">
            <label for="client_type">Тип клиента:</label>
            <select name="client_type" class="form-control {{ $errors->has('client_type') ? 'alert-danger' : ''  }}">
                <option value="">( выбрать )</option>
                <option>физ. лицо</option>
                <option>юр. лицо</option>
            </select>
        </div>

        <div class="form-group">
            <label for="inn">ИНН</label>
            <input class="form-control {{ $errors->has('inn') ? 'alert-danger' : ''  }}" type="text" name="inn" value="{{ old('inn')  }}">
        </div>

        <div class="form-group">
            <label for="pay_type">Способ оплаты:</label>
            <select name="pay_type" class="form-control {{ $errors->has('pay_type') ? 'alert-danger' : ''  }}">
                <option value="">( выбрать )</option>
                <option>нал</option>
                <option>безнал</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pay_type">Способ доставки:</label>
            <select name="delivery_type" class="form-control {{ $errors->has('delivery_type') ? 'alert-danger' : ''  }}">
                <option value="">( выбрать )</option>
                <option>самовывоз</option>
                <option>доставка</option>
            </select>
        </div>

        <div class="form-group">
            <label for="inn">Адрес:</label>
            <input class="form-control " type="text" name="address" value="{{ old('address')  }}">
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Создать</button>
        </div>

        <div class="form-group">
            <a href="/orders/list">Вернуться к списку заказов</a>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
@endsection