<?php

namespace App\Models;

use App\Models\ITPortal\KnowledgeBase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class TeamName extends Model
{

    protected $table = 'tbl_Team_Names';
    protected $primaryKey = 'TEAM_ID';
    public $timestamps = false;

    protected $fillable = [
        'TEAM_Name',
        'Date_Deleted'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function knowledgeBases() : HasMany
    {
        return $this->hasMany(KnowledgeBase::class);
    }


    //~~~~~~ Search Method ~~~~~~//

    public function getSearchableTeamNamesForKnowledgeBase() : Collection
    {
        return DB::table('tbl_IT_Issue_Log')
            ->join('tbl_Team_Names', 'tbl_IT_Issue_Log.TEAM_ID', '=', 'tbl_Team_Names.TEAM_ID')
            ->select('tbl_Team_Names.TEAM_ID', 'tbl_Team_Names.TEAM_Name')
            ->groupBy('tbl_Team_Names.TEAM_Name', 'tbl_Team_Names.TEAM_ID')
            ->orderBy('tbl_Team_Names.TEAM_Name')
            ->get();
    }
}
