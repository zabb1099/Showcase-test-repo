<?php

namespace App\Models\ITPortal\PrintQueues\DebtsolvIVA;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $connection = 'debtsolv_iva';
    protected $table = 'SMSQueue_StdSMS';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ClientID',
        'CreatedBy',
        'DateCreated',
        'DateSent',
        'SMSText',
        'AwaitingSending',
        'TemplateID',
        'Status',
        'PrintOptions'
    ];
}
