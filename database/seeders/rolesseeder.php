<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\roles;

class rolesseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void             // Izveido datubāzes ierakstus
    {
        roles::create(['name'=>'apmekletajs']);
        roles::create(['name'=>'administrators']);
        roles::create(['name'=>'registrets']);
    }
}
