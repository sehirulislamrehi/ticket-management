<?php

namespace App\Services\Backend\Modules\UserModule\User;

use App\Interfaces\UserModule\Role\RoleReadInterface;
use App\Interfaces\UserModule\User\UserReadInterface;
use App\Interfaces\UserModule\User\UserWriteInterface;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Traits\ApiResponseTrait;
use App\Traits\FilePathTrait;
use Exception;

class UserService
{

    use ApiResponseTrait, FilePathTrait;
    protected $user_read_repository;
    protected $user_write_repository;
    protected $role_read_repository;
    protected $common_service;

    public function __construct(
        UserReadInterface $user_read_interface,
        UserWriteInterface $user_write_interface,
        RoleReadInterface $role_read_interface,
        CommonService $common_service
    ) {
        $this->user_read_repository = $user_read_interface;
        $this->user_write_repository = $user_write_interface;
        $this->role_read_repository = $role_read_interface;
        $this->role_read_repository = $role_read_interface;
        $this->common_service = $common_service;
    }

    public function index()
    {
        if (can('all_user')) {
            return view("backend.modules.user_module.user.index");
        } else {
            return view("errors.403");
        }
    }

    public function data()
    {
        try{
            if (can('all_user')) {
                $user = $this->find_all_user_data();
                return $this->make_user_datatable($user);
            } else {
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }

    public function add_modal()
    {
        try {
            if (can('add_user')) {
                $roles = $this->find_active_role_data();
                return view("backend.modules.user_module.user.modals.add", compact("roles"));
            } else {
                return unauthorized();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function add($request)
    {
        try {
            if (can('add_user')) {
                return $this->create($request);
            } else {
                return $this->warning(null, unauthorized());
            }
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            if (can("edit_user")) {
                $user = $this->find_user_by_id($id);
                if (!$user) {
                    return "User not found";
                }
                $roles = $this->find_active_role_data();
                return view("backend.modules.user_module.user.modals.edit", compact("user", "roles"));
            } else {
                return unauthorized();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($request, $id)
    {
        if (can('edit_user')) {
            try {
                $user = $this->find_user_by_id($id);
                if (!$user) {
                    return "User not found";
                }
                return $this->user_write_repository->update($request, $user);
            } catch (Exception $e) {
                return $this->error(null, $e->getMessage());
            }
        } else {
            return $this->warning(null, unauthorized());
        }
    }

    public function reset_modal($id)
    {
        try {
            if (can("reset_password")) {
                $user = $this->find_user_by_id($id);
                if (!$user) {
                    return "User not found";
                }
                return view("backend.modules.user_module.user.modals.reset", compact("user"));
            } else {
                return unauthorized();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function reset($id, $request)
    {
        if (can("reset_password")) {
            try {
                $user = $this->find_user_by_id($id);
                if (!$user) {
                    return "User not found";
                }
                return $this->user_write_repository->reset_password($request, $user);
            } catch (Exception $e) {
                return $this->error(null, $e->getMessage());
            }
        } else {
            return $this->warning(null, unauthorized());
        }
    }

    public function edit_my_profile_page()
    {
        try {
            $auth = auth('web')->user();
            $image = $this->common_service->get_image_link($auth->image,$this->get_file_path("profile"));

            return view("backend.modules.user_module.user.pages.edit_my_profile", compact("auth", "image"));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function edit_my_profile($request)
    {
        try {
            $id = auth('web')->user()->id;
            $user = $this->user_read_repository->get_user_by_id($id);
            if (!$user) {
                return "User not found";
            }
            return $this->user_write_repository->update_profile($request,$user);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage());
        }
    }

    public function edit_my_password($request)
    {
        try {
            $id = auth('web')->user()->id;
            $user = $this->user_read_repository->get_user_by_id($id);
            if (!$user) {
                return "User not found";
            }
            return $this->user_write_repository->change_my_password($request,$user);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage());
        }
    }

    public function find_all_user_data(){
        return $this->user_read_repository->get_all_user_data();
    }

    public function make_user_datatable($user){
        return $this->user_read_repository->user_datatable($user);
    }

    public function find_active_role_data(){
        return $this->role_read_repository->get_active_role_data()->get();
    }

    public function create($request){
        return $this->user_write_repository->create($request);
    }

    public function find_user_by_id($id){
        return $this->user_read_repository->get_user_by_id($id);
    }

}

?>