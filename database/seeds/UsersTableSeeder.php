<?php
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Admin',
            'email' => 'admin@admin.com',
            'role' => Config::get('auth.user_scopes.is_admin'),
            'password' => bcrypt('pass321'),
        ]);
    }
}
