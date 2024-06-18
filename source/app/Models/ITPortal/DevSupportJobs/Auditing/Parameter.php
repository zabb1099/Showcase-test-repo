<?php

namespace App\Models\ITPortal\DevSupportJobs\Auditing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Parameter extends Model
{
    protected $table = 'Jobs_Parameters';
    public $timestamps = false;

    protected $fillable = [
        'audit_id',
        'parameter_name',
        'value'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function audit() : BelongsTo
    {
        return $this->belongsTo(Audit::class);
    }
}
