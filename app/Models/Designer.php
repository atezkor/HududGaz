<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string org_name
 * @property Project projects
 */
class Designer extends Model {

    protected $fillable = ['org_name', 'leader', 'address', 'address_krill', 'phone', 'date_reg', 'date_end', 'document'];

    public function projects(): HasMany {
        return $this->hasMany(Project::class, 'designer');
    }
}
