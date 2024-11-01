<?php

namespace App\Repositories\UserModule\User;

use App\Interfaces\UserModule\User\UserReadInterface;
use App\Models\UserModule\User;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Traits\FilePathTrait;

class UserReadRepository implements UserReadInterface
{

    use FilePathTrait;
    protected $common_service;

    public function __construct(CommonService $common_service)
    {
        $this->common_service = $common_service;
    }

    public function get_all_user_data()
    {
        $auth = auth('web')->user();
        return User::orderBy('id', 'desc')->select("id", "name", "email", "phone", "is_active", "role_id", "image")->where("id","!=",$auth->id)->where("is_super_admin", false)->with("role");
    }

    public function get_active_user_data()
    {
        $auth = auth('web')->user();
        return User::orderBy('id', 'desc')->select("id", "name", "email", "phone", "is_active", "role_id", "image")->where("id","!=",$auth->id)->where("is_active", true)->with("role");
    }


    public function get_user_by_id($id){
        return User::where("id",$id)->first();
    }

    public function get_user_by_email($email){
        return User::where("email",$email)->first();
    }
}
