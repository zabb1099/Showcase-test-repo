<?php


namespace App\Models\BWPortal;

use Illuminate\Database\Eloquent\Model;

class RoleNames extends Model
{

    protected $table = 'tbl_Role_Names';
    protected $primaryKey = 'ROLE_ID';
    public $timestamps = false;

    protected $fillable = [
        'ROLE_Name',
        'Date_Deleted'
    ];
}


