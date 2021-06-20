<?php

namespace App\Models;

/**
 * @property string org_name
 */
class Designer extends \Illuminate\Database\Eloquent\Model {

    protected $fillable = ['org_name', 'leader', 'address', 'address_krill', 'phone','date_reg', 'date_end', 'document'];
}
