<?php

namespace App\Models\ITPortal;

use App\Http\Requests\ITPortal\UserStation\IndexRequest;
use App\Models\User;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class UserStation extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_BFG_Floor_Plan';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $dates = ['Date_Deleted', 'LastUpdatedOn', 'AddedOn'];
    protected $with = ['creator', 'updater', 'deleter', 'user'];
    const DELETED_AT = 'Date_Deleted';

    protected $fillable = [
        'DeskName',
        'ComputerName',
        'AssignedTo',
        'BankNo',
        'PCNo',
        'OS',
        'RAM',
        'Processor',
        'MSOfficeVersion',
        'IsDualMonitors',
        'Notes',
        'AddedBy',
        'AddedOn',
        'LastUpdatedBy',
        'LastUpdatedOn',
        'Date_Deleted',
        'Deleted_By'
    ];


    //~~~~~~ Search Method ~~~~~~//

    public function searchUserStation(IndexRequest $request) : Builder
    {
        $results = UserStation::query();

        if ($request->has('DeskName') && $request->DeskName)
        {
            $results->where('DeskName', 'LIKE', '%' . $request->DeskName . '%');
        }

        if ($request->has('OS') && $request->OS)
        {
            $results->where('OS', 'LIKE', '%' . $request->OS . '%');
        }

        return $results;
    }


    //~~~~~~ Relationship Methods ~~~~~~//

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'AssignedTo');
    }

    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'AddedBy');
    }

    public function updater() : BelongsTo
    {
        return $this->belongsTo(User::class, 'LastUpdatedBy');
    }

    public function deleter() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Deleted_By');
    }


    //~~~~~~ Boot/Soft Delete Methods ~~~~~~//

    public static function boot()
    {
        parent::boot();

        static::deleting(function($userStation)
        {
            $userStation->Deleted_By = strval(Auth::id());
            $userStation->Date_Deleted = date('Y-m-d H:i:s');
            $userStation->save();
        });
    }

}
