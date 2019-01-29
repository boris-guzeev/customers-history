<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Класс предназначен для ведения Лога изменеий Модели.<br>
 * Наследуйте нужную модель от этого класса и укажите в свойстве <strong>$autologTable</strong> имя таблицы для логирования.<br><br>
 * Таблица Лога должна содержать следующие поля:
 * <ul>
 *  <li>id</li>
 *  <li>affected_row_id - id строки с которой произошли изменения</li>
 *  <li>operation_type - тип операции: Создание, Удаление, Изменение</li>
 *  <li>event_time - время исполнения операции</li>
 * <ul>
 *
 * @package App
 * @property $autologTable Имя таблицы в которую записываются логи
 */
class AutologModel extends Model
{
    protected static $autologTable;

    public static function boot() {
        parent::boot();

        if ( !empty(static::$autologTable) ) {

            if (!Schema::hasTable(static::$autologTable)) {
                $tableName = static::$autologTable;
                throw new \PDOException("Таблицы для логирования '$tableName' не существует! Создайте указанную таблицу для логирования!");
            }

            if (!Schema::hasColumn(static::$autologTable, 'affected_row_id'))
            {
                throw new \PDOException('В таблице для логирования отсутствует необходимое поле "affected_row_id". Создайте его!');
            }
            if (!Schema::hasColumn(static::$autologTable, 'operation_type'))
            {
                throw new \PDOException('В таблице для логирования отсутствует необходимое поле "operation_type". Создайте его!');
            }
            if (!Schema::hasColumn(static::$autologTable, 'event_time'))
            {
                throw new \PDOException('В таблице для логирования отсутствует необходимое поле "event_time". Создайте его!');
            }

            static::created(function($instance) {
                DB::table(static::$autologTable)->insert(
                    [
                        'affected_row_id' => $instance->id,
                        'operation_type' => 'Создание',
                        'event_time' => date('Y-m-d H:i:s')
                    ]
                );
            });

            static::updated(function ($instance) {
                DB::table(static::$autologTable)->insert(
                    [
                        'affected_row_id' => $instance->id,
                        'operation_type' => 'Изменение',
                        'event_time' => date('Y-m-d H:i:s')
                    ]
                );
            });

            static::deleted(function($instance) {
                DB::table(static::$autologTable)->insert(
                    [
                        'affected_row_id' => $instance->id,
                        'operation_type' => 'Удаление',
                        'event_time' => date('Y-m-d H:i:s')
                    ]
                );
            });
        }

    }
}

