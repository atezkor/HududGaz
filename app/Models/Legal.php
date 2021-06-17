<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legal extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['proposition_id', 'organ', 'legal_stir', 'legal_name', 'email', 'leader', 'leader_stir', 'phone', 'status'];

    public function getNameAttribute(): string {
        return $this->getAttribute('legal_name');
    }

    public function getPersonNameAttribute() {
        return $this->getAttribute('leader');
    }
}
