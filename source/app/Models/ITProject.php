<?php

namespace App\Models;

use App\Models\ITPortal\KnowledgeBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class ITProject extends Model
{

    protected $table = 'tbl_IT_Projects';
    protected $primaryKey = 'ITP_ID';
    public $timestamps = false;

    protected $fillable = [
        'Project_Name',
        'Project_Decription',
        'Project_Link',
        'Date_Created'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function issueLogs() : HasMany
    {
        return $this->hasMany(KnowledgeBase::class);
    }


    //~~~~~~ Search Method ~~~~~~//

    public function getSearchableProjectsForKnowledgeBase() : Collection
    {
        return DB::table('tbl_IT_Issue_Log')
            ->join('tbl_IT_Projects', 'tbl_IT_Issue_Log.ITP_ID', '=', 'tbl_IT_Projects.ITP_ID')
            ->select('tbl_IT_Projects.ITP_ID', 'tbl_IT_Projects.Project_Name')
            ->groupBy('tbl_IT_Projects.Project_Name', 'tbl_IT_Projects.ITP_ID')
            ->orderBy('tbl_IT_Projects.Project_Name')
            ->get();
    }
}
