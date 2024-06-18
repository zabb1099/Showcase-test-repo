<?php

namespace App\Models\ITPortal\DevSupportJobs\MeetingOutcome;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class MeetingOutcome extends Model
{
    protected $connection = 'debtsolv_iva';
    protected $table = 'Client_IVAMeeting';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $with = ['meetingOutcomeType'];

    protected $fillable = [
        'ClientID',
        'OfficialReceiversExpenses',
        'PetitionCosts',
        'OfficeHoldersFeesAndExps',
        'Nominee',
        'Supervisor',
        'SolicitorsFees',
        'AgentsFees',
        'CostOfCreditorsMeeting',
        'ClientPrintChairmansRPT',
        'PartnerPrintChairmansRPT',
        'MaxMonthlySupervisorsFees',
        'IVARegistration1',
        'IVARegistration2',
        'MeetingDecision',
        'PaymentScheduleType',
        'MinimumDividendPercentage',
        'ExpectedDividendPercentage',
        'DividendTolerancePercentage',
        'ExpectedDividendAmount',
        'MinimumDividendAmount',
        'Nominee2',
        'Nominee3',
        'Supervisor2',
        'Supervisor3',
        'TotalMeetingsClaims',
        'RegistrationDate',
        'IDProven_Client',
        'IDProven_Partner',
        'AddressProven_Client',
        'AddressProven_Partner',
        'BordereauxStatus',
        'BondedAmount',
        'BondPremium',
        'MeetingAdjournedTo',
        'MeetingStatus',
        'MaxAnnualSupervisorsFees',
        'BankCheck_Client',
        'BankCheck_Partner',
        'MeetingsOfficer',
        'SupervisionOfficer',
        'Status',
        'OfficialReceiversExpenses_VAT',
        'OfficialReceiversCosts',
        'OfficialReceiversCosts_VAT',
        'PetitionCosts_VAT',
        'SolicitorsFees_VAT',
        'AgentsFees_VAT',
        'NomineesDisbursements',
        'NomineesDisbursements_VAT',
        'ExpectedMeetingDate',
        'ProposedDisbursements',
        'ProposedDisbursements_VAT',
        'DistributionProfileID',
        'MaxNominees',
        'MaxSupervisors',
        'MaxFirstYearSupervisors',
        'BankruptcyRetainer',
        'ProgramDuration',
        'FeeScheduleTypeID',
        'FeePercentage',
        'MeetingDefinitionID',
        'Description',
        'IsProtocolCompliant',
        'ExpectedPreferentialDividendAmount',
        'ExpectedPreferentialDividendPercentage',
        'TotalPreferentialClaims',
        'ExpectedSupervisorsFees',
        'ExpectedSupervisorsFeesVAT',
        'CaseId',
        'Locked',
        'BondBatch',
        'RecalculationDate',
        'ExpectedBankruptcyDividend',
        'ExpectedBankruptcyDividendPercentage',
        'ExpectedStandardContributions',
        'ExpectedAssetRelease',
        'GuidId',
        'FinstatArchiveID',
        'ProcessingSchema'
    ];

    //~~~~~~ Relationship Method ~~~~~~//

    public function meetingOutcomeType() : BelongsTo
    {
        return $this->belongsTo(MeetingOutcomeType::class, 'MeetingDecision', 'ID');
    }

}
