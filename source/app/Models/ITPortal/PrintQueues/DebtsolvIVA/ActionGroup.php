<?php

namespace App\Models\ITPortal\PrintQueues\DebtsolvIVA;

use Illuminate\Database\Eloquent\Model;

class ActionGroup extends Model
{
    protected $connection = 'debtsolv_iva';
    protected $table = 'PrintQueue_ActionGroups';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ActionID',
        'UserCreated',
        'ClientID',
        'ReadyToPrint',
        'GroupID',
        'TemplateID',
        'CustomData1',
        'CustomData2',
        'CustomData3',
        'Recipient',
        'SourceObjectID',
        'SourceID',
        'IgnoreImmediate',
        'ProfileComponentID'
    ];
}
