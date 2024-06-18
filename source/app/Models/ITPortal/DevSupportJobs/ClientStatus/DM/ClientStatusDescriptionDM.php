<?php

namespace App\Models\ITPortal\DevSupportJobs\ClientStatus\DM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientStatusDescriptionDM extends Model
{
    protected $connection = 'debtsolv';
    protected $table = 'Type_Client_Status';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Description'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function clientStatuses() : HasMany
    {
        return $this->hasMany(ClientStatusDM::class, 'Status', 'ID');
    }
}
