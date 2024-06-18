<?php

namespace App\Models\ITPortal\DevSupportJobs\ClientStatus\IVA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientStatusDescriptionIVA extends Model
{
    protected $connection = 'debtsolv_iva';
    protected $table = 'Type_Client_Status';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Description'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function clientStatuses() : HasMany
    {
        return $this->hasMany(ClientStatusIVA::class, 'Status', 'ID');
    }

}
