<?php

use Illuminate\Database\Seeder;
use App\SerieColor;
class SerieColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SerieColor::firstOrCreate ([
        	'codigo' => '20',
        	'color' => 'Rojo'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => 'A2',
        	'color' => 'Bordo'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '65',
        	'color' => 'Gris'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '40',
        	'color' => 'Azul'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '13',
        	'color' => 'Aqua'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '01',
        	'color' => 'Blanco'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '70',
        	'color' => 'Negro'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '66',
        	'color' => 'Gris Melange'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '60',
        	'color' => 'Verde'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '37',
        	'color' => 'Navy'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '41',
        	'color' => 'Marino'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '29',
        	'color' => 'Turquesa'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '15',
        	'color' => 'Rosa'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '6A',
        	'color' => 'Rosa Viejo'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '12',
        	'color' => 'Limon'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => 'MO',
        	'color' => 'Mosqueta'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '25',
        	'color' => 'Lila'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '02',
        	'color' => 'Crudo'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '95',
        	'color' => 'Multicolor'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '17',
        	'color' => 'Fucsia'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '74',
        	'color' => 'Menta'
        ]);
        SerieColor::firstOrCreate ([
        	'codigo' => '63',
        	'color' => 'Oliva'
        ]);
    }
}
