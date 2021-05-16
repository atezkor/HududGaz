<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposition extends Model {
    use HasFactory;

    protected $fillable = ['number', 'district', 'activity_type', 'applicant', 'build_type', 'status', 'type', 'file', 'delete_at'];

    function individual(): Individual|Model {
        return $this->hasOne(Individual::class)->first();
    }

    function legal(): Legal|Model {
        return $this->hasOne(Legal::class)->first();
    }

    function limit(): int {
        return Status::query()->find($this->getAttribute('status'))->getAttribute('term');
    }

    function percent(): string {
        $now = time() - date_timestamp_get($this->getAttribute('updated_at'));
        $percent = 100 - $now / (3600 * $this->limit()) * 100;
        return number_format($percent, 0, '.', '');
    }
}
