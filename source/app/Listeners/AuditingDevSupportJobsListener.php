<?php

namespace App\Listeners;

use App\Models\ITPortal\DevSupportJobs\Auditing\Audit;
use App\Models\ITPortal\DevSupportJobs\Auditing\Field;
use App\Models\ITPortal\DevSupportJobs\Auditing\Parameter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditingDevSupportJobsListener
{
    public function handle($event)
    {
        $audit = Audit::create([
            'job_name' => $event->auditingParameters['job_name'],
            'changed_by' => strval(Auth::id()),
            'changed_at' => DB::raw('GETDATE()'),
            'reason_changed' => $event->auditingParameters['reason'],
            'action_type' => $event->auditingParameters['action_type']
        ]);

        foreach ($event->auditingParameters['parameter_values'] as $key => $val) {
            Parameter::create([
                'audit_id' => $audit->id,
                'parameter_name' => $event->auditingParameters['parameter_values'][$key]->parameter_name,
                'value' => $event->auditingParameters['parameter_values'][$key]->value
            ]);
        }

        foreach ($event->auditingParameters['field_values'] as $key => $val) {
            Field::create([
                'audit_id' => $audit->id,
                'primary_key' => $event->auditingParameters['field_values'][$key]->primary_key,
                'database_name' => $event->auditingParameters['field_values'][$key]->database_name,
                'table_name' => $event->auditingParameters['field_values'][$key]->table_name,
                'field_name' => $event->auditingParameters['field_values'][$key]->field_name,
                'old_value' => $event->auditingParameters['field_values'][$key]->old_value,
                'new_value' => $event->auditingParameters['field_values'][$key]->new_value
            ]);
        }

    }
}
