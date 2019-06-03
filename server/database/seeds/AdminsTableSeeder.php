<?php

use App\Models\Admin;

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        Admin::query()->truncate();
        Admin::query()->create([
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT)
        ]);
    }
}
