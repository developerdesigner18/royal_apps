<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Kaylin';
        $user->email = 'ahsoka.tano@royal-apps.io';
        $user->password = Hash::make('Kryze4President');
        $user->save();
    }
}
