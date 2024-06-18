<?php

namespace App\Models\ITPortal\DevSupportJobs\MeetingOutcome;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class MeetingOutcomeType extends Model
{
    protected $connection = "debtsolv_iva";
    protected $table = 'Type_MeetingOutcome';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Description'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function meetingOutcomes() : HasMany
    {
        return $this->hasMany(MeetingOutcome::class, 'MeetingDecision', 'ID');
    }

}
