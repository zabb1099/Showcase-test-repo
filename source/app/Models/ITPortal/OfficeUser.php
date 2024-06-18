<?php

namespace App\Models\ITPortal;

use App\Http\Requests\ITPortal\OfficeUser\IndexRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class OfficeUser extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_Office_Users';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $dates = ['Date_Deleted', 'LastUpdatedOn', 'AddedOn'];
    protected $with = ['creator', 'updater', 'deleter'];
    const DELETED_AT = 'Date_Deleted';

    protected $fillable = [
        'Version',
        'Key',
        'email',
        'password',
        'PCName',
        'UserName',
        'AddedBy',
        'AddedOn',
        'LastUpdatedBy',
        'LastUpdatedOn',
        'Notes',
        'Date_Deleted',
        'Deleted_By'
    ];


    //~~~~~~ Search Method ~~~~~~//

    public function searchOfficeUser(IndexRequest $request) : Builder
    {
        $results = OfficeUser::query();

        if ($request->has('email') && $request->email)
        {
            $results->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->has('UserName') && $request->UserName)
        {
            $results->where('UserName', 'LIKE', '%' . $request->UserName . '%');
        }

        return $results;
    }


    //~~~~~~ Relationship Methods ~~~~~~//

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

        static::deleting(function($officeUser)
        {
            $officeUser->Deleted_By = strval(Auth::id());
            $officeUser->Date_Deleted = date('Y-m-d H:i:s');
            $officeUser->save();
        });
    }

}
