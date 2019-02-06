<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Order extends AutologModel
{
    protected static $autologTable = 'orders_log';
    protected $guarded = ['id'];

    /**
     * Метод ищет все заказы Клиента, исходя из параметров поиска
     *
     * @param null $Uphone Поиск заказов, где есть этот телефон. Или в основном или в добавочном
     * @param null $Uemail Поиск всех заказов с указанным Email
     * @param null $Uinn Поиск всех заказов с этим ИНН
     *
     * @return mixed
     * @throws \Exception Должен быть задан хотябы один параметр для поиска
     */
    public static function getCustomerHistory($Uphone = null, $Uemail = null, $Uinn = null)
    {
        if (empty($Uphone) && empty($Uemail) && empty($Uinn)) {
            throw new \Exception('Не задано ни одного параметра для поиска! Укажите хотябы один из параметров!');
        }

        $customerPhones = [];
        $customerEmails = [];
        $customerInns = [];

        function getRelatedOrders(&$customerPhones, &$customerEmails, &$customerInns, $phone = null, $email = null, $inn = null)
        {
            $queryBuilder = DB::table('orders');
            $queryBuilder->select(['phone', 'phone2', 'email', 'inn']);

            if (!empty($phone)) {
                $queryBuilder->orWhere('phone', $phone);
                $queryBuilder->orWhere('phone2', $phone);
            }
            if (!empty($email)) {
                $queryBuilder->orWhere('email', $email);
            }
            if (!empty($inn)) {
                $queryBuilder->orWhere('inn', $inn);
            }

            $results = $queryBuilder->get()->all();

            foreach ($results as $result) {
                if (!empty($result->phone)) {
                    if (!isset($customerPhones[$result->phone])) {
                        $customerPhones[$result->phone] = true;
                        getRelatedOrders($customerPhones, $customerEmails, $customerInns, $result->phone, null, null);
                    }
                }

                if (!empty($result->phone2)) {
                    if (!isset($customerPhones[$result->phone2])) {
                        $customerPhones[$result->phone2] = true;
                        getRelatedOrders($customerPhones, $customerEmails, $customerInns, $result->phone2, null, null);
                    }

                }
                if (!empty($result->email)) {
                    if (!isset($customerEmails[$result->email])) {
                        $customerEmails[$result->email] = true;
                        getRelatedOrders($customerPhones, $customerEmails, $customerInns, null, $result->email, null);
                    }

                }
                if (!empty($result->inn)) {
                    if (!isset($customerInns[$result->inn])) {
                        $customerInns[$result->inn] = true;
                        getRelatedOrders($customerPhones, $customerEmails, $customerInns, null, null, $result->inn);
                    }

                }
            }

        }

        getRelatedOrders($customerPhones, $customerEmails, $customerInns, $Uphone, $Uemail, $Uinn);

        $resultQueryBuilder = DB::table('orders');
        $result = $resultQueryBuilder->whereIn('phone', array_keys($customerPhones))
            ->select('id')
            ->orWhereIn('phone2', array_keys($customerPhones))
            ->orWhereIn('email', array_keys($customerEmails))
            ->orWhereIn('inn', array_keys($customerInns))
            ->pluck('id');

        return $result;
    }

    /*public static function boot() {
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
    }*/
}