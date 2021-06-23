<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property string short_name
 */
class Mounter extends BaseModel {

    public $timestamps = false;
    protected $fillable = ['rec_num', 'reg_num', 'full_name', 'short_name', 'leader',
        'district', 'address', 'taxpayer_stir', 'given_by', 'date_created', 'date_expired', 'permission_to', 'implement_for', 'document'];
}
