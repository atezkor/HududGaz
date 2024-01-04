<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property int type
 * @property int status
 * @property int $organization_id
 * @property string $name
 * @property string $number
 * @property-read string $pdf
 * @property-read int $build_type
 * @property-read Applicant $applicant
 * @property-read Applicant $petitioner
 * @property-read Recommendation recommendation
 * @property-read TechCondition techCondition
 * @property-read Organ organ
 * @property-read Activity activity
 */
class Proposition extends Application {

    public const CREATED = 1;
    public const REVIEWED = 2;
    public const ACCEPTED = 3;

    public const PRESENTED = 4;

    public const IN_PROCESS = 4;
    public const COMPLETED = 5;
    public const TECHNIC_CHECKED = 5;
    public const REC_REJECTED = 6;

    public const TC_CREATED = 7;
    public const PROJECT_C = 8;
    public const PROJECT_CANCELLED = 9;
    public const PROJECT_CREATED = 10;
    public const PROJECT_FINISHED = 14;

    public const MONTAGE_CREATED = 15;

    public const ACCEPT = "accept";
    public const REJECT = "reject";

    protected $fillable = [
        'number', 'organization_id', 'type',
        'activity_type', 'build_type', 'status', 'pdf'
    ];

    public function individual(): HasOne {
        return $this->hasOne(PhysicalApplicant::class);
    }

    public function legal(): HasOne {
        return $this->hasOne(LegalApplicant::class);
    }

    public function applicant(): HasOne {
        return $this->hasOne(Applicant::class);
    }

    public function petitioner(): HasOne {
        return $this->type == self::PHYSICAL ? $this->individual() : $this->legal();
    }

    public function recommendation(): HasOne {
        return $this->hasOne(Recommendation::class);
    }

    public function techCondition(): HasOne {
        return $this->hasOne(TechCondition::class);
    }

    public function organ(): BelongsTo {
        return $this->belongsTo(Organ::class, 'organization_id');
    }

    public function activity(): BelongsTo {
        return $this->belongsTo(Activity::class, 'activity_type_id');
    }

    public function buildType(): string { // TODO remove
        return [
            1 => __('global.proposition.residential'),
            2 => __('global.proposition.non_residential')
        ][$this->build_type];
    }
}
