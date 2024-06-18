<?php

namespace App\Models\ITPortal;

use App\Http\Requests\ITPortal\AssetRegister\IndexRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AssetRegister extends Model
{

    use SoftDeletes;

    protected $table = 'tbl_IT_Asset_register';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $dates = ['Date_Deleted', 'Last_Updated_On', 'Date_Given'];
    protected $with = ['updater', 'deleter'];
    const DELETED_AT = 'Date_Deleted';

    protected $fillable = [
        'Name',
        'Asset_Type',
        'Model',
        'Serial_No',
        'Date_Added',
        'ZeroTier_IP_LPT',
        'Zero_Tier_IP_PC',
        'Last_Updated_On',
        'Last_Updated_By',
        'EMP_ID',
        'EmployeeName',
        'LP_username',
        'LP_password',
        'Date_Deleted',
        'Deleted_By',
        'Date_Given'
    ];


    //~~~~~~ Search Method ~~~~~~//

    public function searchAssetRegister(IndexRequest $request) : Builder
    {
        $results = AssetRegister::query();
        $search = $request->search;

        if ($request->has('search') && $search)
        {
            $results->where('EmployeeName', 'LIKE', '%' . $search . '%')
                ->orWhere('Serial_No', 'LIKE', '%' . $search . '%')
                ->orWhere('Model', 'LIKE', '%' . $search . '%')
                ->orWhere('Asset_Type', 'LIKE', '%' . $search . '%')
                ->orWhere('Name', 'LIKE', '%' . $search . '%');
        }

        return $results;
    }


    //~~~~~~ Relationship Methods ~~~~~~//

    public function updater() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Last_Updated_By');
    }

    public function deleter() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Deleted_By');
    }


    //~~~~~~ Boot/Soft Delete Methods ~~~~~~//

    public static function boot()
    {
        parent::boot();

        static::deleting(function($assetRegister)
        {
            $assetRegister->Deleted_By = strval(Auth::id());
            $assetRegister->Date_Deleted = date('Y-m-d H:i:s');
            $assetRegister->save();
        });
    }

}
