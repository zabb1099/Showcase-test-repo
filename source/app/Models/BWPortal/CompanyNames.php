<?php

namespace App\Models\BWPortal;

use Illuminate\Database\Eloquent\Model;

class CompanyNames extends Model
{

    protected $table = 'tbl_Company_Names';
    protected $primaryKey = 'COMP_ID';
    public $timestamps = false;

    protected $fillable = [
        'COMP_Name',
        'Date_Deleted',
        'Email_Format',
        'Company_Number'
    ];
}


