<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

Role::create(['name' => 'user']);

class User2Seeder extends Seeder
{
    public function run()
    {
        $user = new User;
        $user->assignRole('user');
        $user->name = 'user';
        $user->email = 'user@mail.ru';
        $user->password = Hash::make('123123123');
        $user->save();
    }
}
