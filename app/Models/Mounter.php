<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string short_name
 * @property Collection<Montage> montages
 */
class Mounter extends Model {

    protected $fillable = [
        'full_name', 'short_name', 'director', 'rec_num', 'reg_num',
        'tin', 'district_id', 'phone', 'address', 'date_registry', 'date_expiry',
        'given_by', 'permissions', 'implementations', 'license'
    ];

    public function montages(): HasMany {
        return $this->hasMany(Montage::class);
    }
}
