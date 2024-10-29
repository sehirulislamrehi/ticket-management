<?php

namespace App\Http\Controllers\Backend\UserModule\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Modules\UserModule\User\ChangeMyPasswordRequest;
use App\Http\Requests\Backend\Modules\UserModule\User\CreateUserRequest;
use App\Http\Requests\Backend\Modules\UserModule\User\EditProfileRequest;
use App\Http\Requests\Backend\Modules\UserModule\User\EditUserRequest;
use App\Http\Requests\Backend\Modules\UserModule\User\ResetPasswordRequest;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Services\Backend\Modules\UserModule\User\UserService;

class UserController extends Controller
{

    protected $user_service;
    protected $common_service;

    public function __construct(
        UserService $user_service,
        CommonService $common_service
    ) {
        $this->user_service = $user_service;
        $this->common_service = $common_service;
    }

    public function index()
    {
        return $this->user_service->index();
    }

    public function data()
    {
        return $this->user_service->data();
    }

    public function add_modal()
    {
        return $this->user_service->add_modal();
    }

    public function add(CreateUserRequest $request)
    {
        return $this->user_service->add($request);
    }

    public function edit($id)
    {
        return $this->user_service->edit($id);
    }

    public function update(EditUserRequest $request, $id)
    {
        return $this->user_service->update($request, $id);
    }

    public function reset_modal($id)
    {
        return $this->user_service->reset_modal($id);
    }

    public function reset($id, ResetPasswordRequest $request)
    {
        return $this->user_service->reset($id, $request);
    }

    public function edit_my_profile_page()
    {
        return $this->user_service->edit_my_profile_page();
    }

    public function edit_my_profile(EditProfileRequest $request)
    {
        return $this->user_service->edit_my_profile($request);
    }

    public function edit_my_password(ChangeMyPasswordRequest $request)
    {
        return $this->user_service->edit_my_password($request);
    }
}
