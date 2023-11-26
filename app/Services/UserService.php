<?php

namespace App\Services;

use App\Models\User;
use App\Utilities\CryptoHash;
use App\Utilities\StorageManager;


class UserService extends CrudService {
    use StorageManager, CryptoHash;

    private string $path = "storage/users/";

    public function __construct(User $user) {
        $this->model = $user;
    }

    public function create($data) {
        $data['password'] = $this->hashed($data['password']);
        parent::create($data);
    }

    public function update($data, $model) {
        if (isset($data['password']))
            $data['password'] = $this->hashed($data['password']);
        else
            $data['password'] = $model->password;

        if (isset($data['avatar'])) {
            $this->deleteFile($this->path, $model->avatar);
            $data['avatar'] = $this->createFile($this->path, $data['avatar']);
        }

        parent::update($data, $model);
    }

    public function delete($model) {
        if (isset($data['avatar'])) {
            $this->deleteFile($this->path, $model->avatar);
        }

        parent::delete($model);
    }

    function roles(): array {
        return [
            User::ROLE_ADMIN => __('global.roles.admin'),
            User::TECHNIC => __('global.roles.technic'),
            User::ORGAN => __('global.roles.organ'),
            User::DESIGNER => __('global.roles.designer'),
            User::ENGINEER => __('global.roles.engineer'),
            User::MOUNTER => __('global.roles.mounter'),
            User::DIRECTOR => __('global.roles.director'),
        ];
    }
}
