<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property string $license
 */
class Fitter extends Model {
    public $timestamps = false;

    protected $fillable = ['firm_id', 'statement_number', 'first_name', 'second_name', 'last_name', 'date_contract',
        'date_contract_end', 'diploma_number', 'passport_series', 'specialization', 'experience', 'document'];

    public function firm(): BelongsTo { // Foreign key -> Fitter modelining firm_id ustuni
        return $this->belongsTo(Mounter::class, 'firm_id');
    }
}
