<?php

namespace App\Repositories\UserModule\Role;

use App\Interfaces\UserModule\Role\RoleReadInterface;
use App\Models\UserModule\Role;

class RoleReadRepository implements RoleReadInterface{

    public function get_all_role_data(){
        return Role::select("id", "name", "is_active");
    }

    public function get_active_role_data(){
        return Role::select("id", "name", "is_active")->where("is_active", true);
    }

    public function get_role_by_id($id){
        return Role::where("id",$id)->first();
    }
}

?>