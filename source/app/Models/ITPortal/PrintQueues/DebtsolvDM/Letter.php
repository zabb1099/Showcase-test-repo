<?php

namespace App\Models\ITPortal\PrintQueues\DebtsolvDM;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $connection = 'debtsolv';
    protected $table = 'PrintQueue_StdLetters';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ClientID',
        'TemplateID',
        'CreatedBy',
        'DateCreated',
        'DatePrinted',
        'Undersigned',
        'Telephone',
        'Address1',
        'Address2',
        'Address3',
        'Address4',
        'Address5',
        'Address6',
        'Address7',
        'Greeting',
        'ReadyToPrint',
        'Reason',
        'LetterType',
        'Type_Correspondence',
        'PrintOption',
        'OverRideDate',
        'LinkedObjID',
        'ClientSelection',
        'CorrespondenceSummaryNote',
        'ObjectTypeID',
        'ObjectID',
        'CreditorID',
        'Address8'
    ];
}
