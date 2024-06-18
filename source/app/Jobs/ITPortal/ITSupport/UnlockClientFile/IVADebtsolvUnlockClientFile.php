<?php /** @noinspection DuplicatedCode */

namespace App\Jobs\ITPortal\ITSupport\UnlockClientFile;

use App\Events\ITPortal\DevSupportJobs\UnlockClientFile\IVADebtsolvUnlockClientFileEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class IVADebtsolvUnlockClientFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'Client_Lock';
    protected $clientId;
    protected $reason;

    public function __construct($clientId, $reason)
    {
        $this->clientId = $clientId;
        $this->reason = $reason;
    }

    public function handle()
    {
        $fieldValues = array();

        $parameterValues = array(
            (object)[
                'parameter_name' => 'ClientID',
                'value' => $this->clientId,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('ClientID', '=', $this->clientId)
            ->delete();

        // Dispatch Event for Auditing
        IVADebtsolvUnlockClientFileEvent::dispatch([
            'job_name' => static::class,
            'reason' => $this->reason,
            'action_type' => 'DELETE',
            'parameter_values' => $parameterValues,
            'field_values' => $fieldValues
        ]);
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }
}
