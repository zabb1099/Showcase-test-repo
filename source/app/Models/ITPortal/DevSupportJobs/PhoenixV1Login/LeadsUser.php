<?php

namespace App\Models\ITPortal\DevSupportJobs\PhoenixV1Login;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadsUser extends Model
{
    protected $connection = 'leads';
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
        'status',
        'username',
        'academy_type',
        'DeletedDate',
        'DeadStatus_SignOff',
        'Is_manager',
        'queue_id',
        'DDI',
        'Mobile_DDI',
        'm_queue_id',
        'sip_order'
    ];


    //~~~~~~ Relationship Methods ~~~~~~//

    public function userType() : BelongsTo
    {
        return $this->belongsTo(LeadsUserType::class, 'UST_ID');
    }

}
