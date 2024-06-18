<?php

namespace App\Models\ITPortal\DevSupportJobs\ClientType\DM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientTypeDM extends Model
{
    protected $connection = 'debtsolv';
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
        'HistoricalReceiptsAmount'
    ];

    //~~~~~~ Relationship Methods ~~~~~~//

    public function clientTypeDescription() : BelongsTo
    {
        return $this->belongsTo(ClientTypeDescriptionDM::class, 'ClientType', 'ID');
    }

}
