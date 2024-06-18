<?php


namespace App\Models\BWPortal;

use Illuminate\Database\Eloquent\Model;

class DepartmentNames extends Model
{

    protected $table = 'tbl_Department_Names';
    protected $primaryKey = 'DEPT_ID';
    public $timestamps = false;

    protected $fillable = [
        'DEPT_Name',
        'Date_Deleted'
    ];
}


