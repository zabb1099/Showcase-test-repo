<?php

namespace App\Models\ITPortal\DevSupportJobs\ClientStatus\DM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientStatusDM extends Model
{
    protected $connection = 'debtsolv';
    protected $table = 'Client_Contact';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $with = ['clientStatusDescription'];

    protected $fillable = [
        'Status'
    ];

    //~~~~~~ Relationship Methods ~~~~~~//

    public function clientStatusDescription() : BelongsTo
    {
        return $this->belongsTo(ClientStatusDescriptionDM::class, 'Status', 'ID');
    }

}
