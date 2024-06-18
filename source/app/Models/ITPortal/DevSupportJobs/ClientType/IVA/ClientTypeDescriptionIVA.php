<?php

namespace App\Models\ITPortal\DevSupportJobs\ClientType\IVA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientTypeDescriptionIVA extends Model
{
    protected $connection = "debtsolv_iva";
    protected $table = 'Type_ClientDefinition';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Description'
    ];


    //~~~~~~ Relationship Method ~~~~~~//

    public function clientTypes() : HasMany
    {
        return $this->hasMany(ClientTypeIVA::class, 'ClientType', 'ID');
    }
}
