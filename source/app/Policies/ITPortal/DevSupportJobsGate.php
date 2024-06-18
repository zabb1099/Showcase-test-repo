<?php

namespace App\Policies\ITPortal;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevSupportJobsGate
{
    use HandlesAuthorization;

    private $allowedUserId = [1];

    /**
     * Unlock Client Files.
     */
    public function fssUnlockClientFile(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function dmDebtsolvUnlockClientFile(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function ivaDebtsolvUnlockClientFile(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Update IVA Bond.
     */
    public function removeDuplicateBond(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function updateBondRenewalDate(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Process Payouts.
     */
    public function dmDebtsolvProcessPayout(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function ivaDebtsolvProcessPayout(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * New BACS Creditors.
     */
    public function dmDebtsolvNewBACSCreditor(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function ivaDebtsolvNewBACSCreditor(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Update client file to a test case.
     */
    public function leadsTestCaseClient(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Remove second IVA meeting on a client's file.
     */
    public function removeSecondMeeting(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Update IVA meeting outcome on a client's file.
     */
    public function meetingOutcome(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Update Users table on Leads DB to create a Phoenix V1 user account.
     */
    public function createPhoenixLogin(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Generate XMLs
     */
    public function generateXML(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /** Generate RX1 form or Sale of Property Letter **/
    public function isRX1Required(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Update and Delete Lead Dispositions.
     */
    public function updateHistoryLeadDispositions(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function deleteAssignedLeadDispositions(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Update Client Type
     */
    public function dmDebtsolvUpdateClientType(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function ivaDebtsolvUpdateClientType(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Update Client Status
     */
    public function dmDebtsolvUpdateClientStatus(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function ivaDebtsolvUpdateClientStatus(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Update Users table on FSS DB to update a BFG Portal user account
     */
    public function updateBFGPortalLogin(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Create / Update Bulk Creditor
     */
    public function dmDebtsolvUpdateBulkCreditor(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function ivaDebtsolvUpdateBulkCreditor(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Process Errored Card Payments
     */
    public function dmDebtsolvProcessCardPayment(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function ivaDebtsolvProcessCardPayment(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    /**
     * Delete Duplicate Debtsolv Files
     */
    public function dmDeleteDuplicateDebtsolvFiles(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function ivaDeleteDuplicateDebtsolvFiles(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

}
