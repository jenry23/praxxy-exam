<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'title' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Role::insert($roles);
    }
}
