<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maklad\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Super Admin', 'Admin', 'Publisher', 'Institute'];

        foreach ($roles as $role) {
            if (!Role::where('name', $role)->first())
                Role::create(['name' => $role]);
        }
    }
}
