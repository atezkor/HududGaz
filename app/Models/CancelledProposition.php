<?php

namespace App\Models;

/**
 * @property string proposition
 * @property string recommendation
 * @property string condition
 */
class CancelledProposition extends Application {

    protected $fillable = ['prop_num', 'applicant', 'proposition', 'recommendation', 'condition', 'reason'];
}
