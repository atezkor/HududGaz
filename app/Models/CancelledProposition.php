<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string proposition
 * @property string recommendation
 * @property string condition
 */
class CancelledProposition extends Model {
    use HasFactory;

    protected $fillable = ['prop_num', 'applicant', 'recommendation', 'proposition', 'condition', 'reason'];
}
