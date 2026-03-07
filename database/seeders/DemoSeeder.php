<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cotisation;

class DemoSeeder extends Seeder
{
    public function run(): void
    {

        // utilisateur test
        $user = User::create([
            'name' => 'Utilisateur Test',
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);

        // générer 100 cotisations
        Cotisation::factory(100)->create([
            'user_id' => $user->id
        ]);

    }
}