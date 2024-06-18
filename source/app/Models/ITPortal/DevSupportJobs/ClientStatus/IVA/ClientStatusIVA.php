<?php

namespace App\Models\ITPortal\DevSupportJobs\ClientStatus\IVA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientStatusIVA extends Model
{
    protected $connection = 'debtsolv_iva';
    protected $table = 'Client_Contact';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $with = ['clientStatusDescription'];

    protected $fillable = [
        'Status'
    ];

    //~~~~~~ Relationship Method ~~~~~~//

    public function clientStatusDescription() : BelongsTo
    {
        return $this->belongsTo(ClientStatusDescriptionIVA::class, 'Status', 'ID');
    }

}
