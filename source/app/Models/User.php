<?php

namespace App\Models;

use App\Models\ITPortal\ITNotice;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ITPortal\AssetRegister;
use App\Models\ITPortal\KnowledgeBase;
use App\Models\ITPortal\OfficeUser;
use App\Models\ITPortal\UserStation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{

    use HasApiTokens, Notifiable;

    protected $table = 'tbl_sys_Users';
    protected $primaryKey = 'USR_ID';
    public $timestamps = false;

    protected $fillable = [
        'UST_Title',
        'UST_First_Name',
        'UST_Last_Name',
        'USR_Full_Name',
        'USR_Login',
        'UST_ID',
        'USR_Unlimited',
        'Last_Project',
        'Date_Deleted',
        'Date_Created',
        '_NU_err',
        'Created_By',
        'tmp_pass',
    ];

    protected $hidden = [
        'USR_Password',
        'USR_DSPassword'
    ];


    // FIXME - define foreign keys
    // TODO - Note - Commented out until needed

//    public function knowledgeBases() : HasMany
//    {
//        return $this->hasMany(KnowledgeBase::class);
//    }
//
//    public function assetRegisters() : HasMany
//    {
//        return $this->hasMany(AssetRegister::class);
//    }
//
//    public function officeUsers() : HasMany
//    {
//        return $this->hasMany(OfficeUser::class);
//    }
//
//    public function userStations() : HasMany
//    {
//        return $this->hasMany(UserStation::class);
//    }
//
//    public function categories() : HasMany
//    {
//        return $this->hasMany(Category::class);
//    }
//
//    public function questions() : HasMany
//    {
//        return $this->hasMany(Question::class);
//    }
//
//    public function tickets() : HasMany
//    {
//        return $this->hasMany(Ticket::class);
//    }

//  public function itNotices() : HasMany
//  {
//        return $this->hasMany(ITNotice::class);
//  }


    //~~~~~~ Search Methods ~~~~~~//


    public function getAllUsers() : Collection
    {
        return DB::table('tbl_sys_Users')
            ->select('USR_ID', 'UST_Title', 'UST_First_Name', 'UST_Last_Name', 'USR_Full_Name')
            ->whereNull('tbl_sys_Users.Date_Deleted')
            ->orderBy('tbl_sys_Users.USR_Full_Name')
            ->get();
    }

    public function getSearchableUsersForKnowledgeBase() : Collection
    {
        return DB::table('tbl_IT_Issue_Log')
            ->Join('tbl_sys_Users', 'tbl_IT_Issue_Log.Created_By', '=', 'tbl_sys_Users.USR_ID')
            ->select('tbl_sys_Users.USR_ID', 'tbl_sys_Users.USR_Full_Name')
            ->whereNull('tbl_sys_Users.Date_Deleted')
            ->groupBy('tbl_sys_Users.USR_Full_Name', 'tbl_sys_Users.USR_ID')
            ->orderBy('tbl_sys_Users.USR_Full_Name')
            ->get();
    }

    public function getSearchableUsersForOfficeUsers() : Collection
    {
        return DB::table('tbl_Office_Users')
            ->Join('tbl_sys_Users', 'tbl_Office_Users.AddedBy', '=', 'tbl_sys_Users.USR_ID')
            ->select('tbl_sys_Users.USR_ID', 'tbl_sys_Users.USR_Full_Name')
            ->whereNull('tbl_sys_Users.Date_Deleted')
            ->groupBy('tbl_sys_Users.USR_Full_Name', 'tbl_sys_Users.USR_ID')
            ->orderBy('tbl_sys_Users.USR_Full_Name')
            ->get();
    }


    //~~~~~~ Login Methods ~~~~~~//

    public function findForPassport($userIdentifier)
    {
        return $this->where('USR_Login', $userIdentifier)->first();
    }

    public function validateForPassportPasswordGrant($password): bool
    {
        $sql = "SELECT 1 as [check] FROM [tbl_sys_Users] WHERE [USR_ID] = ? AND PWDCOMPARE(?, USR_Password) = 1;";

        $result = DB::selectOne($sql, [$this->USR_ID, $password]);

        return $result ? $result->check == 1 : false;
    }
}
