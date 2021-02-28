<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            'company' => 'PASEO DE MONTEJO',
            'rules' => 'Reglamento del estacionamiento donde se describen todas las reglas que se aplicaran Reglamento del estacionamiento donde se describen todas las reglas que se aplicaran Reglamento del estacionamiento donde se describen todas las reglas que se aplicaran ',
            'price_hours' => 20.00,
            'quarter1' => 5.00,
            'quarter2' => 10.00,
            'quarter3' => 15.00,
            'quarter4' => 20.00,
            'printer' => '',
            'amountLost' => 250.00

        ]);
    }
}
