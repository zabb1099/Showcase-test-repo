<?php

namespace App\Models\ITPortal\DevSupportJobs\BFGPortalLogin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FSSUserType extends Model
{
    protected $connection = 'fss';
    protected $table = 'tbl_sys_User_Types';
    protected $primaryKey = 'UST_ID';
    public $timestamps = false;

    protected $fillable = [
        'UST_ID',
        'UST_Name',
        'UST_New_User_Form',
        'Date_Created'
    ];


    //~~~~~~ Relationship Methods ~~~~~~//

    public function userTypes() : HasMany
    {
        return $this->hasMany(FSSUser::class, 'UST_ID');
    }
}
