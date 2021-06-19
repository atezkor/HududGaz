<?php

namespace App\Models;

class Mounter extends \Illuminate\Database\Eloquent\Model {

    public $timestamps = false;
    protected $fillable = ['rec_num', 'reg_num', 'full_name', 'short_name', 'leader',
        'district', 'address', 'taxpayer_stir', 'given_by', 'date_created', 'date_expired', 'permission_to', 'implement_for', 'document'];
}
