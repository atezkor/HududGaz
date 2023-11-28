<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string short_name
 * @property Montage montages
 */
class Mounter extends Model {

    public $timestamps = false;
    protected $fillable = ['rec_num', 'reg_num', 'full_name', 'short_name', 'leader',
        'district', 'address', 'taxpayer_stir', 'given_by', 'date_created', 'date_expired', 'permission_to', 'implement_for', 'document'];

    public function montages(): HasMany {
        return $this->hasMany(Montage::class, 'firm');
    }
}
