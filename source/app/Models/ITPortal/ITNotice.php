<?php


namespace App\Models\ITPortal;

use App\Http\Requests\ITPortal\ITNotice\IndexRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class ITNotice extends Model
{
    use SoftDeletes;

    protected $table = 'IT_Notices';

    protected $with = [
        'creator',
        'deleter',
        'updater'
    ];

    protected $fillable = [
        'notice_header',
        'notice_body',
        'priority_level',
        'created_by',
        'updated_by',
        'deleted_by',
    ];



    public function searchITNotices($created_by, $notice_header, $notice_body, $priority_level)
    {
        $results = ITNotice::query();

        if ($created_by != null) {
            $results->where('created_by', $created_by);
        }

        if ($notice_header != null) {
            $results->where('notice_header', $notice_header);
        }

        if ($notice_body != null) {
            $results->where('notice_body', $notice_body);
        }

        if ($priority_level != null) {
            $results->where('priority_level', $priority_level);
        }

        $results->orderBy('created_by', 'desc');
        $results->paginate();
        $results->get();

    }


        public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function deleter() : BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }


    public function updater() : BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


     public static function boot()
    {
        parent::boot();

        static::deleting(function($itNotice)
        {
            $itNotice->deleted_by = strval(Auth::id());
            $itNotice->deleted_at = date('Y-m-d H:i:s');
            $itNotice->save();
        });
    }
}
