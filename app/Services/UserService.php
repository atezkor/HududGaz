<?php

namespace App\Services;

use App\Models\User;
use App\Utilities\CryptoHash;
use App\Utilities\StorageManager;
use Exception;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;


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

    /**
     * @param array $data
     * @param User $model
     * @throws Exception
     */
    public function update(array $data, $model) {
        if (isset($data['password'])) {
            if (!$this->check($data['password_old'], $model->password)) {
                throw new Exception(__("global.profile.wrong_pass"));
            }

            $data['password'] = $this->hashed($data['password']);
        }

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

    #[ArrayShape([User::ROLE_ADMIN => "string", User::TECHNIC => "string", User::ORGAN => "string", User::DESIGNER => "string", User::ENGINEER => "string", User::MOUNTER => "string", User::DIRECTOR => "string"])]
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

    private function check($pass, $hasPass): bool {
        // $password = auth()->user()->getAuthPassword();
        return Hash::check($pass, $hasPass);
    }
}
