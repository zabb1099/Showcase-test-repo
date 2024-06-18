<?php

namespace App\Models\ITPortal;

use App\Http\Requests\ITPortal\KnowledgeBase\IndexRequest;
use App\Models\ITProject;
use App\Models\TeamName;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class KnowledgeBase extends Model
{

    use SoftDeletes;

    protected $table = 'tbl_IT_Issue_Log';
    protected $primaryKey = 'ITL_ID';
    public $timestamps = false;
    protected $dates = ['Date_Created', 'Date_Deleted'];
    protected $with = ['itProjects', 'teamNames', 'creator', 'deleter'];
    const DELETED_AT = 'Date_Deleted';

    protected $fillable = [
        'ITL_GR_ID',
        'ITP_ID',
        'TEAM_ID',
        'Issue_Type',
        'Short_Name',
        'Issue_Description',
        'Solution_Description',
        'Date_Created',
        'Created_By',
        'Date_Deleted',
        'Deleted_By'
    ];


    //~~~~~~ Search Method ~~~~~~//

    public function searchKnowledgeBase(IndexRequest $request) : Builder
    {
        $results = KnowledgeBase::query();

        if ($request->has('Created_By') && $request->Created_By)
        {
            $results->where('Created_By', $request->Created_By);
        }

        if ($request->has('ITP_ID') && $request->ITP_ID)
        {
            $results->where('ITP_ID', $request->ITP_ID);
        }

        if ($request->has('TEAM_ID') && $request->TEAM_ID)
        {
            $results->where('TEAM_ID', $request->TEAM_ID);
        }

        if ($request->has('Short_Name') && $request->Short_Name)
        {
            $results->where('Short_Name', 'LIKE', '%' . $request->Short_Name . '%');
        }

        if ($request->has('Issue_Type') && $request->Issue_Type)
        {
            $results->where('Issue_Type', 'LIKE', '%' . $request->Issue_Type . '%');
        }

        return $results;
    }


    //~~~~~~ Relationship Methods ~~~~~~//

    public function itProjects() : BelongsTo
    {
        return $this->belongsTo(ITProject::class, 'ITP_ID');
    }

    public function teamNames() : BelongsTo
    {
        return $this->belongsTo(TeamName::class, 'TEAM_ID');
    }

    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Created_By');
    }

    public function deleter() : BelongsTo
    {
        return $this->belongsTo(User::class, 'Deleted_By');
    }


    //~~~~~~ Boot/Soft Delete Methods ~~~~~~//

    public static function boot()
    {
        parent::boot();

        static::deleting(function($knowledgeBase)
        {
            $knowledgeBase->Deleted_By = strval(Auth::id());
            $knowledgeBase->Date_Deleted = date('Y-m-d H:i:s');
            $knowledgeBase->save();
        });
    }

}
