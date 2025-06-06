<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**d
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->count(3)->create();
    }
}
