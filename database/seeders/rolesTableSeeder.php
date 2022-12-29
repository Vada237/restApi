<?php

namespace Database\Seeders;

use App\Models\roles;
use Illuminate\Database\Seeder;

class rolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        roles::create([
            'name' => 'admin'
        ]);
        roles::create([
            'name' => 'waiter'
        ]);
    }
}
