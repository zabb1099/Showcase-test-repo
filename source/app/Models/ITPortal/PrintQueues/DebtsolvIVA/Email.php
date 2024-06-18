<?php

namespace App\Models\ITPortal\PrintQueues\DebtsolvIVA;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $connection = 'debtsolv_iva';
    protected $table = 'EMessage_Queue';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ServiceType',
        'TemplateID',
        'RequiresCorrespondenceNote',
        'FromName',
        'SourceFaxNo',
        'SourceEmail',
        'ToName',
        'Subject',
        'MessageText',
        'ClientID',
        'NumAttachments',
        'CreatedBy',
        'DateCreated',
        'DateSent',
        'ReadyToSend',
        'ServiceID'
    ];
}
