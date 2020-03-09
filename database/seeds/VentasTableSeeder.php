<?php

use App\Venta;
use Illuminate\Database\Seeder;

class VentasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Venta::class, 3)->create()->each(function ($venta) {

	    });
    }
}
