<?php

namespace App\Http\Controllers\Backend\UserModule\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Modules\UserModule\Role\CreateRoleRequest;
use App\Services\Backend\Modules\UserModule\Role\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $role_service;

    public function __construct(RoleService $role_service)
    {
        return $this->role_service = $role_service;
    }

    public function index()
    {
        return $this->role_service->index();
    }

    public function data()
    {
        return $this->role_service->data();
    }

    public function add_modal()
    {
        return $this->role_service->add_modal();
    }


    public function add(CreateRoleRequest $request)
    {
        return $this->role_service->add($request);
    }


    public function edit($id)
    {
        return $this->role_service->edit($id);
    }


    public function update(Request $request, $id)
    {
        return $this->role_service->update($request,$id);
    }
}
