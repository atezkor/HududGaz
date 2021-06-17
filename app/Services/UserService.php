<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService extends CrudService {

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
            $this->deleteFile($model->avatar);
            $data['avatar'] = $this->createFile($data['avatar']);
        }

        parent::update($data, $model);
    }

    private function hashed(string $password): string {
        return Hash::make($password);
    }

    private function createFile($file): string {
        $name = time() . '.' . $file->extension();
        $file->move($this->path, $name);
        return $name;
    }

    protected function deleteFile($file) {
        File::delete($this->path . $file);
    }
}
