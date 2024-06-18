<?php

namespace App\Models\ITPortal\DevSupportJobs\PhoenixV1Login;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadsUserType extends Model
{
    protected $connection = 'leads';
    protected $table = 'tbl_sys_User_Types';
    protected $primaryKey = 'UST_ID';
    public $timestamps = false;

    protected $fillable = [
        'UST_ID',
        'UST_Name',
        'UST_New_User_Form',
        'Date_Created',
        'DEP_ID'
    ];


    //~~~~~~ Relationship Methods ~~~~~~//

    public function userTypes() : HasMany
    {
        return $this->hasMany(LeadsUser::class, 'UST_ID');
    }
}
