<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $license
 * @property Collection<Project> $projects
 */
class Designer extends Model {

    protected $fillable = ['name', 'director', 'address', 'address_cyrill', 'phone', 'registry_date', 'expiry_date', 'license'];

    public function projects(): HasMany {
        return $this->hasMany(Project::class);
    }
}
