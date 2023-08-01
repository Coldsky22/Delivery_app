<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

Role::create(['name' => 'admin']);

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User;
        $user->assignRole('admin');
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('admin');
        $user->save();
    }
}
