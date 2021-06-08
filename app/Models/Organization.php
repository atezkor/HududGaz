<?php

namespace App\Models;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class Organization {

    public string $shareholder_name = '';
    public string $branch_name = '';
    public string $engineer = '';
    public string $helper_engineer = '';
    public string $tech_section = '';
    public string $legal_section = '';
    public string $met_section = '';
    public string $exploitation_section = '';
    public string $phone = '';
    public ?int $reg_num = null;
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
        $this->tech_section = $data['tech_section'] ?: '';
        $this->legal_section = $data['legal_section'] ?: '';
        $this->met_section = $data['met_section'] ?: '';
        $this->exploitation_section = $data['exploitation_section'] ?: '';
        $this->reg_num = $data['reg_num'];
        $this->phone = $data['phone'] ?: '';
        $this->address = $data['address'] ?: '';
        $this->address_latin = $data['address_latin'] ?: '';
        $this->email = $data['email'] ?: '';
        $this->fax = $data['fax'] ?: '';

        $logo = Cache::get('organization')->logo ?? '';
        if (isset($data['logo'])) {
            $this->logo = $this->fileCreate($data['logo']);
            $this->fileDelete($logo);
        } else {
            $this->logo = $logo;
        }
    }

    public static function Data(): Organization {
        return Cache::get('organization') ?: new Organization();
    }

    private function fileCreate($file): string {
        $name = time() . '.' . $file->extension();
        $file->move('storage/images', $name);
        return $name;
    }

    private function fileDelete($path) {
        File::delete('storage/images/' . $path);
    }
}
