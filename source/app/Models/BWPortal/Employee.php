<?php

namespace App\Models\BWPortal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{

    protected $table = 'tbl_Employee';
    protected $primaryKey = 'USR_ID';
    public $timestamps = false;

    protected $fillable = [
        'COMP_ID',
        'DEPT_ID',
        'TEAM_ID',
        'ROLE_ID',
        'EMP_NI_Number',
        'EMP_Date_of_Birth',
        'EMP_DFH_Start_Date',
        'EMP_Start_Date',
        'EMP_Probation_End_Date',
        'EMP_Probation_Extented_Date',
        'EMP_Home_Tel',
        'EMP_Mobile_Tel',
        'EMP_Email',
        'EMP_Work_Email',
        'EMP_Emergency_Contact',
        'EMP_Leave_Date',
        'EMP_Reason_Leaving',
        'EMP_Starter_Pack_Send',
        'Date_Created',
        'EMP_Line1',
        'EMP_Line2',
        'EMP_Line3',
        'EMP_Line4',
        'EMP_Postcode',
        'HOL_Per_Year',
        'EMP_Bank_AcNo',
        'EMP_Bank_SC',
        'EMP_Bank_Name',
        'H_L1_Manager',
        'H_F_Manager'
    ];


    //~~~~~~ Search Method ~~~~~~//

    public function getAllEmployees() : Collection
    {
        return DB::table('tbl_Employee')
            ->Join('tbl_sys_Users', 'tbl_Employee.USR_ID', '=', 'tbl_sys_Users.USR_ID')
            ->Join('tbl_Company_Names', 'tbl_Employee.COMP_ID', '=', 'tbl_Company_Names.COMP_ID')
            ->Join('tbl_Department_Names', 'tbl_Employee.DEPT_ID', '=', 'tbl_Department_Names.DEPT_ID')
            ->Join('tbl_Role_Names', 'tbl_Employee.ROLE_ID', '=', 'tbl_Role_Names.ROLE_ID')
            ->Join('tbl_Team_Names', 'tbl_Employee.TEAM_ID', '=', 'tbl_Team_Names.TEAM_ID')
            ->select(
                'tbl_sys_Users.USR_Full_Name',
                'tbl_sys_Users.USR_Login',
                'tbl_Company_Names.COMP_Name',
                'tbl_Department_Names.DEPT_Name',
                'tbl_Team_Names.TEAM_Name',
                'tbl_Role_Names.ROLE_Name'
            )
            ->whereNull('tbl_sys_Users.Date_Deleted')
            ->orderBy('tbl_sys_Users.USR_Full_Name')
            ->get();
    }
}

