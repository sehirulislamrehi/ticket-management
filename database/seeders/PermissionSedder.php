<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement("DELETE FROM permissions");

        DB::table('permissions')->insert([
            [
                'id' => 1,
                'key' => 'user_module',
                'display_name' => 'User Module',
                'module_id' => 1,
            ],
            [
                'id' => 2,
                'key' => 'all_user',
                'display_name' => 'All User',
                'module_id' => 1,
            ],
            [
                'id' => 3,
                'key' => 'add_user',
                'display_name' => '-- Add User',
                'module_id' => 1,
            ],
            [
                'id' => 4,
                'key' => 'edit_user',
                'display_name' => '-- Edit User',
                'module_id' => 1,
            ],
            [
                'id' => 5,
                'key' => 'reset_password',
                'display_name' => '-- Reset Password',
                'module_id' => 1,
            ],
            [
                'id' => 6,
                'key' => 'roles',
                'display_name' => 'Roles',
                'module_id' => 1,
            ],
            [
                'id' => 7,
                'key' => 'complaint_module',
                'display_name' => 'Complaint Module',
                'module_id' => 2,
            ],
            [
                'id' => 8,
                'key' => 'complaint',
                'display_name' => '- Complaint',
                'module_id' => 2,
            ],
            [
                'id' => 9,
                'key' => 'add_complaint',
                'display_name' => '-- Add Complaint',
                'module_id' => 2,
            ],
            [
                'id' => 10,
                'key' => 'edit_complaint',
                'display_name' => '-- Edit Complaint',
                'module_id' => 2,
            ],
        ]);
    }
}