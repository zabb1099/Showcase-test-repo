<?php

namespace App\Models\ITPortal\PrintQueues\DebtsolvIVA;

use Illuminate\Database\Eloquent\Model;

class SSRS extends Model
{
    protected $connection = 'debtsolv_iva';
    protected $table = 'ssrs_PrintQueue_Letters';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ClientID',
        'Date_Created',
        'CreatedBy',
        'ReadyToPrint',
        'LetterGroup',
        'SSRS_Location',
        'Date_Printed',
        'Print_Qty',
        'LType',
        'Stop_Qty',
        'Is_Partner',
        'p_version',
        'print_type',
        'LType_Sub',
        'Is_Regenerated',
        'BookmarkGroupID'
    ];
}
