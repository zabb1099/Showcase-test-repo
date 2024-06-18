<?php

namespace App\Models\ITPortal\DevSupportJobs\Auditing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Field extends Model
{
    protected $table = 'Jobs_Fields';
    public $timestamps = false;

    protected $fillable = [
        'audit_id',
        'primary_key',
        'database_name',
        'table_name',
        'field_name',
        'old_value',
        'new_value'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function audit() : BelongsTo
    {
        return $this->belongsTo(Audit::class);
    }
}
