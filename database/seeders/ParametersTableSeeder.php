<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Parameters;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParametersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parameters::firstOrCreate(
            [
                'account' => '00000000000000000000000000',
                'email' => 'email@email.pl',
            ]);
    }
}
