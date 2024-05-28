<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Package;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'=>'Manos',
            'email'=>'manos@dev.com',
            'password'=>bcrypt('123.321Aa'),
        ]);

        Feature::create([
           'image'=>'',
           'route_name'=>'feature1.index',
           'name'=>'Calculer la somme',
           'description'=>'Calculer la somme de deux nombres',
           'required_credits'=>1,
            'active'=>true,
        ]);

        Feature::create([
            'image' => 'https://cdn-icons-png.freepik.com/512/929/929430.png',
            'route_name' => 'feature2.index',
            'name' => 'Calculer la difference',
            'description' => 'Calculer la diffrence entre deux nombres',
            'required_credits' => 3,
            'active' => true,
        ]);

        Package::create([
            'name'=> 'Bronze',
            'price'=> 5,
            'credits'=> 20,
        ]);
        Package::create([
            'name' => 'Argent',
            'price' => 20,
            'credits' => 100,
        ]);
        Package::create([
            'name' => 'Or',
            'price' => 50,
            'credits' => 500,
        ]);
    }
}
