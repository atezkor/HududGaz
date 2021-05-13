<?php

namespace App\Models;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class Organization {

    public string $shareholder_name = '';
    public string $branch_name = '';
    public string $engineer = '';
    public string $helper_engineer = '';
    public string $phone = '';
    public int $reg_num = 0;
    public string $address = '';
    public string $address_latin = '';
    public string $email = '';
    public string $fax = '';
    public string $logo = '';

    public function setData(Array $data) {
        $this->shareholder_name = $data['shareholder_name'] ?: '';
        $this->branch_name = $data['branch_name'] ?: '';
        $this->engineer = $data['engineer'] ?: '';
        $this->helper_engineer = $data['helper_engineer'] ?: '';
        $this->reg_num = $data['reg_num'] ?: 1;
        $this->phone = $data['phone'] ?: '';
        $this->address = $data['address'] ?: '';
        $this->address_latin = $data['address_latin'] ?: '';
        $this->email = $data['email'] ?: '';
        $this->fax = $data['fax'] ?: '';

        $cache = Cache::get('organization')->logo ?? '';
        if (isset($data['logo'])) {
            $this->delete($cache);
            $this->logo = $this->filePath($data['logo']);
        } else {
            $this->logo = $cache;
        }
    }

    private function filePath($file): string {
        $name = time() . '.' . $file->extension();
        $file->move('storage/images', $name);
        return $name;
    }

    private function delete($path) {
        File::delete('storage/images/' . $path);
    }
}
