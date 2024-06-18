<?php

namespace App\Models\ITPortal\DevSupportJobs\ClientType\DM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientTypeDescriptionDM extends Model
{
    protected $connection = 'debtsolv';
    protected $table = 'Type_ClientDefinition';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Description'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function clientTypes() : HasMany
    {
        return $this->hasMany(ClientTypeDM::class, 'ClientType', 'ID');
    }
}
