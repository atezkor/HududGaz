<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property string org_name
 */
class Designer extends BaseModel {

    protected $fillable = ['org_name', 'leader', 'address', 'address_krill', 'phone','date_reg', 'date_end', 'document'];
}
