<?php

namespace App;
use Illuminate\Support\Facades\DB;

class Order extends AutologModel
{
    protected static $autologTable = 'orders_log';

    /**
     * Метод ищет все заказы Клиента, исходя из параметров поиска
     *
     * @param null $phone Поиск заказов, где есть этот телефон. Или в основном или в добавочном
     * @param null $email Поиск всех заказов с указанным Email
     * @param null $inn Поиск всех заказов с этим ИНН
     * @param false $idsOnly Возвращать только $id заказов
     *
     * @return mixed
     * @throws \Exception Должен быть задан хотябы один параметр для поиска
     */
    public static function getCustomerHistory($phone = null, $email = null, $inn = null, $idsOnly = false)
    {
        if (empty($phone) && empty($email) && empty($inn)) {
            throw new \Exception('Не задано ни одного параметра для поиска! Укажите хотябы один из параметров!');
        }

        $queryBuilder = DB::table('orders');
        if (!empty($phone)) {
            $queryBuilder->where('phone', $phone);
            $queryBuilder->orWhere('phone2', $phone);
        }
        if (!empty($email)) {
            $queryBuilder->orWhere('email', $email);
        }
        if (!empty($inn)) {
            $queryBuilder->orWhere('inn', $inn);
        }

        if ($idsOnly)
            $queryBuilder->select('id');

        return $queryBuilder->get();
    }

    public static function boot() {
        parent::boot();

        static::saving(function($instance) {
            $isOnePhone = empty($instance->phone ) && empty($instance->phone2 );

            if ($instance->client_type == 'физ. лицо') {
                if ( $isOnePhone ) {
                    throw new \Exception("физ. лицо дложно иметь хотябы один телефонный номер! Заполните свойство 'phone' или 'phone2'");
                }
            }
            elseif ($instance->client_type == 'юр. лицо') {
                if ($isOnePhone || !is_integer($instance->inn)) {
                    throw new \Exception("юр. лицо дложно иметь хотябы один телефонный номер и ИНН! Заполните свойство 'phone' или 'phone2' и 'inn'");
                }
            }
            else {
                throw new \Exception("Свойство 'client_type' обязательное! В нем должно быть значение: 'физ. лицо' | 'юр. лицо'");
            }
        });
    }
}