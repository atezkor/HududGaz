<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designer extends Model {
    use HasFactory;

    protected $fillable = ['org_name', 'leader', 'address', 'address_krill', 'phone','date_reg', 'date_end', 'document'];
}
