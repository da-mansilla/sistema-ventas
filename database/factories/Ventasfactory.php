<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Venta;
use Faker\Generator as Faker;

$factory->define(Venta::class, function (Faker $faker) {
	$total = $faker->numberBetween(500,2000);
	$fecha = $faker->dateTimeThisMonth($max = 'now', $timezone = null);
    return [
            'cliente_id' => $faker->randomNumber(3),
            'cliente_id' => $faker->randomNumber(3),	
            'forma_pago' => 'Efectivo',
            'pagoEfectivo' => $total,
            'pagoTarjeta' => 0,
            'total' => $total,
            'seña' => 0,
            'deuda' => 0,
            'estado' => 'Finalizado',
            'enabled' => 1,
           	'created_at' => $fecha,
           	'updated_at' => $fecha,
    ];
});
