<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("DELETE FROM permission_role");

        $permission_ids = [1,2,3,4,5,7,8,9,10];
        $insert_array = [];
        foreach( $permission_ids as $key => $permission_id ){
            array_push($insert_array, [
                'id' => $key + 1,
                'role_id' => 1,
                'permission_id' => $permission_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        DB::table('permission_role')->insert($insert_array);
    }
}
