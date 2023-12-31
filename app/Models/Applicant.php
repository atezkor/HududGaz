<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 */
class Applicant extends Model {
    use HasFactory;

    public const PHYSICAL = 1;
    public const LEGAL = 2;

    protected $fillable = [
        'type', 'physical_applicant_id', 'legal_applicant_id', 'proposition_id', 'name', 'tin_pin'
    ];
}
