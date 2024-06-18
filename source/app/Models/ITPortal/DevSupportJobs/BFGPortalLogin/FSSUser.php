<?php

namespace App\Models\ITPortal\DevSupportJobs\BFGPortalLogin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FSSUser extends Model
{
    protected $connection = 'fss';
    protected $table = 'Users';
    protected $primaryKey = 'UserID';
    public $timestamps = false;
    protected $with = ['userType'];

    protected $fillable = [
        'UserID',
        'UserLoginName',
        'UserPassword',
        'UserIsDeleted',
        'UserDSUserID',
        'UserFullName',
        'UserSessionHash',
        'UserTelephoneNumber',
        'UserEmailAddress',
        'UserNewLeadFlag',
        'UserAssignedLeadFlag',
        'UserNewLeadCount',
        'UST_ID',
        'USR_Unlimited',
        'AcademyUser',
        'WhatsappID',
        'UserIVAUserID',
        'UserGUID',
        'BW_USR_ID',
        'Extension_ID',
        'UserFirstName',
        'UserLastName',
        'Units_cap',
        'FSS_SignableID',
        'COMP_ID',
        'auth_key',
        'password_hash',
        'password_reset_token',
        'username',
        'status',
        'DeadStatus_SignOff',
        'UserLeadsUserID',
        'queue_id',
        'DDI',
        'Mobile_DDI',
        'm_queue_id',
        'isCC2'
    ];


    //~~~~~~ Relationship Methods ~~~~~~//

    public function userType() : BelongsTo
    {
        return $this->belongsTo(FSSUserType::class, 'UST_ID');
    }

}
