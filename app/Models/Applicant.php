<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property int $type
 * @property string $name
 * @property-read PhysicalApplicant|LegalApplicant $petitioner
 */
class Applicant extends Model {
    use HasFactory;

    public $timestamps = false;

    public const PHYSICAL = 1;
    public const LEGAL = 2;

    protected $fillable = [
        'type', 'physical_applicant_id', 'legal_applicant_id', 'proposition_id', 'name', 'tin_pin'
    ];

    public function legal(): BelongsTo {
        return $this->belongsTo(LegalApplicant::class, 'legal_applicant_id');
    }

    public function physical(): BelongsTo {
        return $this->belongsTo(PhysicalApplicant::class, 'physical_applicant_id');
    }

    public function petitioner(): BelongsTo {
        return $this->type == self::PHYSICAL ? $this->physical() : $this->legal();
    }
}
