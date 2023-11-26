<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read Proposition applicant
 * @property-read Recommendation recommendation
 * @property-read TechCondition tech_condition
 * @property-read Organ organization
 * @property-read Activity activity
 * @property int id
 * @property int type
 * @property int status
 * @property int organ
 * @property-read string file
 * @property-read int build_type
 * @property string $name
 */

class Proposition extends Application {

    public const CREATED = 1;
    public const IN_PROCESS = 4;
    public const COMPLETED = 5;

    protected $fillable = ['number', 'organ', 'activity_type', 'applicant', 'build_type', 'status', 'type', 'file', 'delete_at'];

    public function individual(): HasOne {
        return $this->hasOne(IndividualApplication::class);
    }

    public function legal(): HasOne {
        return $this->hasOne(LegalApplication::class);
    }

    public function applicant(): HasOne {
        return $this->type == 1 ? $this->individual() : $this->legal();
    }

    public function recommendation(): HasOne {
        return $this->hasOne(Recommendation::class);
    }

    public function tech_condition(): HasOne {
        return $this->hasOne(TechCondition::class);
    }

    public function organization(): BelongsTo {
        return $this->belongsTo(Organ::class, 'organ');
    }

    public function activity(): BelongsTo {
        return $this->belongsTo(Activity::class, 'activity_type');
    }

    public function buildType(): string {
        return [
            1 => __('global.proposition.residential'),
            2 => __('global.proposition.non_residential')
        ][$this->build_type];
    }
}
