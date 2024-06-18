<?php

namespace App\Models\ITPortal\DevSupportJobs\ClientType\IVA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientTypeIVA extends Model
{
    protected $connection = 'debtsolv_iva';
    protected $table = 'Client_Status';
    protected $primaryKey = 'ClientID';
    public $timestamps = false;
    protected $with = ['clientTypeDescription'];

    protected $fillable = [
        'ClientID',
        'TriggerAmount',
        'OverrideTrigger',
        'OverrideExpiryDate',
        'Baseline',
        'CurrentBalance',
        'UnclearedBalance',
        'AmountOnHold',
        'Status',
        'ClientType',
        'ExtraTrigger1',
        'ExtraTrigger2',
        'FeeSchedule',
        'BankBalance',
        'LastBankUpdate',
        'LastScheduleDate',
        'CurrentScheduleID',
        'NextWageReview',
        'NextIEReview',
        'DefaultContactMethod',
        'HistoricalReceiptsAmount',
        'CurrentMeetingID'
    ];

    //~~~~~~ Relationship Method ~~~~~~//

    public function clientTypeDescription() : BelongsTo
    {
        return $this->belongsTo(ClientTypeDescriptionIVA::class, 'ClientType', 'ID');
    }
}
