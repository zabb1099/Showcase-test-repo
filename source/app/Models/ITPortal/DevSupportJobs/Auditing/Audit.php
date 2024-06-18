<?php

namespace App\Models\ITPortal\DevSupportJobs\Auditing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Audit extends Model
{
    protected $table = 'Jobs_Audit';
    public $timestamps = false;
    protected $with = ['parameters', 'fields'];

    protected $fillable = [
        'job_name',
        'changed_by',
        'changed_at',
        'reason_changed',
        'action_type'
    ];

    //~~~~~~ Relationship Methods ~~~~~~//

    public function parameters() : HasMany
    {
        return $this->hasMany(Parameter::class);
    }

    public function fields() : HasMany
    {
        return $this->hasMany(Field::class);
    }
}
