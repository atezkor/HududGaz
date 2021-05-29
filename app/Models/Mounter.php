<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mounter extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['rec_num', 'reg_num', 'full_name', 'short_name', 'leader',
        'region', 'address', 'taxpayer_stir', 'legal_form', 'given_by', 'date_created', 'date_expired', 'permission_to', 'implement_for', 'document'];
}
