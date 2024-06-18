<?php

namespace App\Jobs\ITPortal\ITSupport\NewBACSCreditor;

use App\Events\ITPortal\DevSupportJobs\NewBACSCreditor\IVANewBACSCreditorEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class IVANewBACSCreditor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = null;
    protected $creditorId;
    protected $reason;

    public function __construct($creditorId, $reason)
    {
        $this->creditorId = $creditorId;
        $this->reason = $reason;
    }

    public function handle()
    {
      $fieldValues = array();

        $parameterValues = array(
            (object)[
                'parameter_name' => 'CreditorID',
                'value' => $this->creditorId,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->update('EXEC [dbo].[sp_UpdatePaymentMethodBACS] ?;',
                [
                    $this->creditorId
                ]
            );

        // Dispatch Event for Auditing
        IVANewBACSCreditorEvent::dispatch([
            'job_name' => static::class,
            'reason' => $this->reason,
            'action_type' => 'EXEC',
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
