<?php

namespace App\Models;

/**
 * @property string proposition
 * @property string recommendation
 * @property string condition
 */
class CancelledProposition extends Application {

    protected $fillable = [
        'number', 'applicant_id', 'organization_id', 'proposition', 'recommendation', 'condition', 'reason'
    ];
}
