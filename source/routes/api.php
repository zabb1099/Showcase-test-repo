<?php

use App\Http\Controllers\BWPortal\Account\NewUserFormController;
use App\Http\Controllers\BWPortal\Account\QuestTemplatesController;
use App\Http\Controllers\BWPortal\Account\UserGroupsController;
use App\Http\Controllers\BWPortal\Account\UsersAdminController;
use App\Http\Controllers\BWPortal\Account\UsersController;
use App\Http\Controllers\BWPortal\BWTrainings\IssueSelfStudyController;
use App\Http\Controllers\BWPortal\BWTrainings\SetUpNewTrainingController;
use App\Http\Controllers\BWPortal\BWTrainings\TrainingSessionsController;
use App\Http\Controllers\BWPortal\CompanyDocs\DocumentManagerController;
use App\Http\Controllers\BWPortal\CompanyDocs\TeamDocumentManagerController;
use App\Http\Controllers\BWPortal\Dashboard\DashboardController;
use App\Http\Controllers\BWPortal\Management\HRHolidaysController;
use App\Http\Controllers\BWPortal\Management\ReAssignTasksController;
use App\Http\Controllers\BWPortal\Management\StarterFormController;
use App\Http\Controllers\BWPortal\Management\TeamHolidaysController;
use App\Http\Controllers\BWPortal\Management\UserAuditsController;
use App\Http\Controllers\BWPortal\MyAccount\CVController;
use App\Http\Controllers\BWPortal\MyAccount\HolidayRequestsController;
use App\Http\Controllers\BWPortal\MyAccount\MyDocumentsController;
use App\Http\Controllers\BWPortal\MyAccount\PersonalInformationController;
use App\Http\Controllers\BWPortal\MyAccount\TeamCalendarController;
use App\Http\Controllers\BWPortal\MyTraining\CompletedController;
use App\Http\Controllers\BWPortal\MyTraining\MyAuditsController;
use App\Http\Controllers\BWPortal\MyTraining\SelfStudyHistoryController;
use App\Http\Controllers\BWPortal\MyTraining\SessionHistoryController;
use App\Http\Controllers\BWPortal\Reports\CPDHoursReportController;
use App\Http\Controllers\BWPortal\Reports\EmployeeListController;
use App\Http\Controllers\BWPortal\Reports\LastAccessController;
use App\Http\Controllers\BWPortal\Reports\SelfStudyOutstandingReportController;
use App\Http\Controllers\BWPortal\Reports\TrainingAndSelfStudyController;
use App\Http\Controllers\BWPortal\Reports\TrainingHistoryController;

use App\Http\Controllers\ITPortal\AssetRegisterController;
use App\Http\Controllers\ITPortal\DevSupportJobs\BulkCreditorController;
use App\Http\Controllers\ITPortal\DevSupportJobs\CardPaymentController;
use App\Http\Controllers\ITPortal\DevSupportJobs\ClientStatusController;
use App\Http\Controllers\ITPortal\DevSupportJobs\ClientTypeController;
use App\Http\Controllers\ITPortal\DevSupportJobs\DuplicateDebtsolvFileDMController;
use App\Http\Controllers\ITPortal\DevSupportJobs\DuplicateDebtsolvFileIVAController;
use App\Http\Controllers\ITPortal\DevSupportJobs\FSSUserController;
use App\Http\Controllers\ITPortal\DevSupportJobs\IsRX1RequiredController;
use App\Http\Controllers\ITPortal\DevSupportJobs\IVAMeetingController;
use App\Http\Controllers\ITPortal\DevSupportJobs\LeadDispositionController;
use App\Http\Controllers\ITPortal\DevSupportJobs\LeadsUserController;
use App\Http\Controllers\ITPortal\DevSupportJobs\NewBACSCreditorController;
use App\Http\Controllers\ITPortal\DevSupportJobs\ProcessPayoutController;
use App\Http\Controllers\ITPortal\DevSupportJobs\TestCaseFileController;
use App\Http\Controllers\ITPortal\DevSupportJobs\UnlockClientFileController;
use App\Http\Controllers\ITPortal\DevSupportJobs\IVABondController;
use App\Http\Controllers\ITPortal\DevSupportJobs\XMLGenerationController;
use App\Http\Controllers\ITPortal\ITNoticeController;
use App\Http\Controllers\ITPortal\KnowledgeBaseController;
use App\Http\Controllers\ITPortal\OfficeUserController;
use App\Http\Controllers\ITPortal\PrintQueues\SSRSController;
use App\Http\Controllers\ITPortal\PrintQueues\DMDebtsolvController;
use App\Http\Controllers\ITPortal\PrintQueues\IVADebtsolvController;
use App\Http\Controllers\ITPortal\UserStationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->group(function () {

    Route::prefix('/it-portal')->group(function () {

        Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->middleware('can:viewKnowledgeBase');
        Route::post('/knowledge-base', [KnowledgeBaseController::class, 'store'])->middleware('can:createKnowledgeBase');
        Route::get('/knowledge-base/{knowledgeBase}', [KnowledgeBaseController::class, 'show'])->middleware('can:viewKnowledgeBase');
        Route::put('/knowledge-base/{knowledgeBase}', [KnowledgeBaseController::class, 'update'])->middleware('can:editKnowledgeBase');
        Route::delete('/knowledge-base/{knowledgeBase}', [KnowledgeBaseController::class, 'destroy'])->middleware('can:deleteKnowledgeBase');

        Route::get('/asset-register', [AssetRegisterController::class, 'index'])->middleware('can:viewAssetRegister');
        Route::post('/asset-register', [AssetRegisterController::class, 'store'])->middleware('can:createAssetRegister');
        Route::get('/asset-register/{assetRegister}', [AssetRegisterController::class, 'show'])->middleware('can:viewAssetRegister');
        Route::put('/asset-register/{assetRegister}', [AssetRegisterController::class, 'update'])->middleware('can:editAssetRegister');
        Route::delete('/asset-register/{assetRegister}', [AssetRegisterController::class, 'destroy'])->middleware('can:deleteAssetRegister');

        Route::get('/office-users', [OfficeUserController::class, 'index'])->middleware('can:viewOfficeUser');
        Route::post('/office-users', [OfficeUserController::class, 'store'])->middleware('can:createOfficeUser');
        Route::get('/office-users/{officeUser}', [OfficeUserController::class, 'show'])->middleware('can:viewOfficeUser');
        Route::put('/office-users/{officeUser}', [OfficeUserController::class, 'update'])->middleware('can:editOfficeUser');
        Route::delete('/office-users/{officeUser}', [OfficeUserController::class, 'destroy'])->middleware('can:deleteOfficeUser');

        Route::get('/user-stations', [UserStationController::class, 'index'])->middleware('can:viewUserStation');
        Route::post('/user-stations', [UserStationController::class, 'store'])->middleware('can:createUserStation');
        Route::get('/user-stations/{userStation}', [UserStationController::class, 'show'])->middleware('can:viewUserStation');
        Route::put('/user-stations/{userStation}', [UserStationController::class, 'update'])->middleware('can:editUserStation');
        Route::delete('/user-stations/{userStation}', [UserStationController::class, 'destroy'])->middleware('can:deleteUserStation');

        Route::get('/it-notices', [ITNoticeController::class, 'index']);
        Route::post('/it-notices', [ITNoticeController::class, 'store'])->middleware('can:createNotice');
        Route::put('/it-notices/{itNotice}', [ITNoticeController::class, 'update'])->middleware('can:editNotice');
        Route::get('/it-notices/{itNotice}', [ITNoticeController::class, 'show'])->middleware('can:viewNotice');
        Route::delete('/it-notices/{itNotice}', [ITNoticeController::class, 'destroy'])->middleware('can:deleteNotice');


        /*
         * Dev Support Jobs.
         */
        Route::prefix('/dev-support-jobs')->group(function () {
            /** Unlock Client File **/
            Route::prefix('/unlock-client-file')->group(function () {
                Route::get('/fss', [UnlockClientFileController::class, 'getFSSUnlockClientFile'])->middleware('can:fssUnlockClientFileDevSupportJobs');
                Route::put('/fss', [UnlockClientFileController::class, 'FSSUnlockClientFile'])->middleware('can:fssUnlockClientFileDevSupportJobs');

                Route::get('/dm-debtsolv', [UnlockClientFileController::class, 'getDMDebtsolvUnlockClientFile'])->middleware('can:dmDebtsolvUnlockClientFileDevSupportJobs');
                Route::delete('/dm-debtsolv', [UnlockClientFileController::class, 'DMDebtsolvUnlockClientFile'])->middleware('can:dmDebtsolvUnlockClientFileDevSupportJobs');

                Route::get('/iva-debtsolv', [UnlockClientFileController::class, 'getIVADebtsolvUnlockClientFile'])->middleware('can:ivaDebtsolvUnlockClientFileDevSupportJobs');
                Route::delete('/iva-debtsolv', [UnlockClientFileController::class, 'IVADebtsolvUnlockClientFile'])->middleware('can:ivaDebtsolvUnlockClientFileDevSupportJobs');
            });
            /** Process Payouts **/
            Route::prefix('/process-payout')->group(function () {
                Route::get('/dm-debtsolv', [ProcessPayoutController::class, 'getAllDMPayouts'])->middleware('can:dmDebtsolvProcessPayoutDevSupportJobs');
                Route::put('/dm-debtsolv', [ProcessPayoutController::class, 'DMDebtsolvProcessPayout'])->middleware('can:dmDebtsolvProcessPayoutDevSupportJobs');

                Route::get('/iva-debtsolv', [ProcessPayoutController::class, 'getAllIVAPayouts'])->middleware('can:ivaDebtsolvProcessPayoutDevSupportJobs');
                Route::put('/iva-debtsolv', [ProcessPayoutController::class, 'IVADebtsolvProcessPayout'])->middleware('can:ivaDebtsolvProcessPayoutDevSupportJobs');
            });
            /** New BACS Creditors **/
            Route::prefix('/new-bacs-creditor')->group(function () {
                Route::put('/dm-debtsolv', [NewBACSCreditorController::class, 'DMNewBACSCreditor'])->middleware('can:dmDebtsolvNewBACSCreditorDevSupportJobs');
                Route::put('/iva-debtsolv', [NewBACSCreditorController::class, 'IVANewBACSCreditor'])->middleware('can:ivaDebtsolvNewBACSCreditorDevSupportJobs');
            });
            /** Update Client File to a Test Case **/
            Route::prefix('/test-case-file')->group(function () {
                Route::get('/leads', [TestCaseFileController::class, 'getLeadsClientFile'])->middleware('can:leadsTestCaseClientDevSupportJobs');
                Route::put('/leads', [TestCaseFileController::class, 'updateLeadsClientFile'])->middleware('can:leadsTestCaseClientDevSupportJobs');
            });
            /** Update IVA Bond **/
            Route::prefix('/iva-bond')->group(function () {
                Route::put('/remove-duplicate-bond', [IVABondController::class, 'RemoveDuplicateBond'])->middleware('can:removeDuplicateBondDevSupportJobs');

                Route::get('/bond-renewal-date', [IVABondController::class, 'getBondRenewalDate'])->middleware('can:updateBondRenewalDateDevSupportJobs');
                Route::put('/bond-renewal-date', [IVABondController::class, 'UpdateBondRenewalDate'])->middleware('can:updateBondRenewalDateDevSupportJobs');
            });
            /** Update IVA Meeting **/
            Route::prefix('/iva-meeting')->group(function () {
                Route::get('/remove-second-meeting', [IVAMeetingController::class, 'getClientIVAMeetings'])->middleware('can:removeSecondMeetingDevSupportJobs');
                Route::put('/remove-second-meeting', [IVAMeetingController::class, 'updateSecondMeeting'])->middleware('can:removeSecondMeetingDevSupportJobs');

                Route::get('/meeting-outcome', [IVAMeetingController::class, 'getMeetingOutcome'])->middleware('can:meetingOutcomeDevSupportJobs');
                Route::put('/meeting-outcome', [IVAMeetingController::class, 'updateMeetingOutcome'])->middleware('can:meetingOutcomeDevSupportJobs');
            });
            /** Create Phoenix V1 Login **/
            Route::prefix('/leads-user')->group(function () {
                Route::get('/create-phoenix-login', [LeadsUserController::class, 'getLeadsUser'])->middleware('can:createPhoenixLoginDevSupportJobs');
                Route::put('/create-phoenix-login', [LeadsUserController::class, 'createLeadsUser'])->middleware('can:createPhoenixLoginDevSupportJobs');
                Route::put('/delete-phoenix-login', [LeadsUserController::class, 'deleteLeadsUser'])->middleware('can:createPhoenixLoginDevSupportJobs');
            });

            /** Generate XMLs **/
            Route::prefix('/generate-xml')->group(function () {
                Route::put('/iva-debtsolv', [XMLGenerationController::class, 'generateXML'])->middleware('can:generateXMLDevSupportJobs');
            });

            /** Generate RX1 form or Sale of Property Letter **/
            Route::get('/is-rx1-required', [IsRX1RequiredController::class, 'getIsRX1Required'])->middleware('can:isRX1RequiredDevSupportJobs');
            Route::put('/is-rx1-required', [IsRX1RequiredController::class, 'updateIsRX1Required'])->middleware('can:isRX1RequiredDevSupportJobs');

            /** Update and Delete Lead Dispositions **/
            Route::prefix('/lead-dispositions')->group(function () {
                Route::get('/update-history', [LeadDispositionController::class, 'getLeadDispositions'])->middleware('can:updateHistoryLeadDispositionsDevSupportJobs');
                Route::put('/update-history', [LeadDispositionController::class, 'updateHistory'])->middleware('can:updateHistoryLeadDispositionsDevSupportJobs');
                Route::put('/update-history-assigned', [LeadDispositionController::class, 'updateHistoryAssigned'])->middleware('can:updateHistoryLeadDispositionsDevSupportJobs');
                Route::put('/update-history-verified', [LeadDispositionController::class, 'updateHistoryVerified'])->middleware('can:updateHistoryLeadDispositionsDevSupportJobs');
                Route::put('/update-assigned', [LeadDispositionController::class, 'updateAssigned'])->middleware('can:updateHistoryLeadDispositionsDevSupportJobs');
                Route::delete('/delete-assigned', [LeadDispositionController::class, 'deleteAssigned'])->middleware('can:deleteAssignedLeadDispositionsDevSupportJobs');
            });

            /** Update Client Type **/
            Route::prefix('/client-type')->group(function () {
                Route::get('/dm-debtsolv', [ClientTypeController::class, 'getDMDebtsolvClientType'])->middleware('can:dmDebtsolvUpdateClientTypeDevSupportJobs');
                Route::put('/dm-debtsolv', [ClientTypeController::class, 'updateDMDebtsolvClientType'])->middleware('can:dmDebtsolvUpdateClientTypeDevSupportJobs');

                Route::get('/iva-debtsolv', [ClientTypeController::class, 'getIVADebtsolvClientType'])->middleware('can:ivaDebtsolvUpdateClientTypeDevSupportJobs');
                Route::put('/iva-debtsolv', [ClientTypeController::class, 'updateIVADebtsolvClientType'])->middleware('can:ivaDebtsolvUpdateClientTypeDevSupportJobs');
            });

            /** Update Client Status **/
            Route::prefix('/client-status')->group(function () {
                Route::get('/dm-debtsolv', [ClientStatusController::class, 'getDMDebtsolvClientStatus'])->middleware('can:dmDebtsolvUpdateClientStatusDevSupportJobs');
                Route::put('/dm-debtsolv', [ClientStatusController::class, 'updateDMDebtsolvClientStatus'])->middleware('can:dmDebtsolvUpdateClientStatusDevSupportJobs');

                Route::get('/iva-debtsolv', [ClientStatusController::class, 'getIVADebtsolvClientStatus'])->middleware('can:ivaDebtsolvUpdateClientStatusDevSupportJobs');
                Route::put('/iva-debtsolv', [ClientStatusController::class, 'updateIVADebtsolvClientStatus'])->middleware('can:ivaDebtsolvUpdateClientStatusDevSupportJobs');
            });

            /** Update BFG Portal Login **/
            Route::prefix('/fss-user')->group(function () {
                Route::get('/update-bfg-portal-login', [FSSUserController::class, 'getFSSUser'])->middleware('can:updateBFGPortalLoginDevSupportJobs');
                Route::put('/update-bfg-portal-login', [FSSUserController::class, 'updateFSSUser'])->middleware('can:updateBFGPortalLoginDevSupportJobs');
                Route::put('/delete-bfg-portal-login', [FSSUserController::class, 'deleteFSSUser'])->middleware('can:updateBFGPortalLoginDevSupportJobs');
            });

            /** Create / Update Bulk Creditor **/
            Route::prefix('/bulk-creditor')->group(function () {
                Route::middleware('can:dmDebtsolvUpdateBulkCreditorDevSupportJobs')->group(function () {
                    Route::get('/dm-debtsolv', [BulkCreditorController::class, 'getDMBulkCreditor']);
                    Route::post('/dm-debtsolv', [BulkCreditorController::class, 'createDMBulkCreditor']);
                    Route::put('/dm-debtsolv', [BulkCreditorController::class, 'updateDMBulkCreditor']);
                });

                Route::middleware('can:ivaDebtsolvUpdateBulkCreditorDevSupportJobs')->group(function () {
                    Route::get('/iva-debtsolv', [BulkCreditorController::class, 'getIVABulkCreditor']);
                    Route::post('/iva-debtsolv', [BulkCreditorController::class, 'createIVABulkCreditor']);
                    Route::put('/iva-debtsolv', [BulkCreditorController::class, 'updateIVABulkCreditor']);
                });
            });

            /** Process Card Payments **/
            Route::prefix('/card-payment')->group(function () {
                Route::middleware('can:dmDebtsolvProcessCardPaymentDevSupportJobs')->group(function () {
                    Route::get('/dm-debtsolv', [CardPaymentController::class, 'getAllDMCardPayments']);
                    Route::put('/dm-debtsolv', [CardPaymentController::class, 'DMDebtsolvCardPayment']);
                });

                Route::middleware('can:ivaDebtsolvProcessCardPaymentDevSupportJobs')->group(function () {
                    Route::get('/iva-debtsolv', [CardPaymentController::class, 'getAllIVACardPayments']);
                    Route::put('/iva-debtsolv', [CardPaymentController::class, 'IVADebtsolvCardPayment']);
                });
            });

            /** Delete Duplicate Debtsolv Files **/
            Route::prefix('/duplicate-file')->group(function () {
                Route::put('/dm-debtsolv', [DuplicateDebtsolvFileDMController::class, 'deleteDuplicateDebtsolvFilesDM'])->middleware('can:dmDeleteDuplicateDebtsolvFilesDevSupportJobs');
                Route::put('/iva-debtsolv', [DuplicateDebtsolvFileIVAController::class, 'deleteDuplicateDebtsolvFilesIVA'])->middleware('can:ivaDeleteDuplicateDebtsolvFilesDevSupportJobs');
            });

        });

        /*
         * Print Managers.
         */
        Route::prefix('/print-queues')->group(function () {
            Route::get('/dm-debtsolv', [DMDebtsolvController::class, 'index']);
            Route::get('/iva-debtsolv', [IVADebtsolvController::class, 'index']);
            Route::get('/ssrs', [SSRSController::class, 'index']);
        });
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('can:authorisedUserLogin');
});

Route::prefix('/bw-portal')->group(function () {
    Route::prefix('/account')->group(function () {
        Route::get('/users', [UsersController::class, 'index']);
        Route::get('/users/{user}', [UsersController::class, 'show']);
        Route::put('/users/{user}', [UsersController::class, 'update']);
        Route::delete('/users/{user}', [UsersController::class, 'destroy']);

        Route::get('/users-admin', [UsersAdminController::class, 'index']);
        Route::post('/users-admin', [UsersAdminController::class, 'store']);
        Route::get('/users-admin/{usersAdmin}', [UsersAdminController::class, 'show']);
        Route::put('/users-admin/{usersAdmin}', [UsersAdminController::class, 'update']);
        Route::delete('/users-admin/{usersAdmin}', [UsersAdminController::class, 'destroy']);

        Route::get('/user-groups', [UserGroupsController::class, 'index']);
        Route::post('/user-groups', [UserGroupsController::class, 'store']);
        Route::get('/user-groups/{userGroup}', [UserGroupsController::class, 'show']);
        Route::put('/user-groups/{userGroup}', [UserGroupsController::class, 'update']);
        Route::delete('/user-groups/{userGroup}', [UserGroupsController::class, 'destroy']);

        Route::get('/new-user-form', [NewUserFormController::class, 'index']);
        Route::post('/new-user-form', [NewUserFormController::class, 'store']);
        Route::get('/new-user-form/{newUserForm}', [NewUserFormController::class, 'show']);
        Route::put('/new-user-form/{newUserForm}', [NewUserFormController::class, 'update']);
        Route::delete('/new-user-form/{newUserForm}', [NewUserFormController::class, 'destroy']);

        Route::get('/quest-templates', [QuestTemplatesController::class, 'index']);
        Route::post('/quest-templates', [QuestTemplatesController::class, 'store']);
        Route::get('/quest-templates/{questTemplate}', [QuestTemplatesController::class, 'show']);
        Route::put('/quest-templates/{questTemplate}', [QuestTemplatesController::class, 'update']);
        Route::delete('/quest-templates/{questTemplate}', [QuestTemplatesController::class, 'destroy']);
    });

    Route::prefix('/bw-trainings')->group(function () {
        Route::get('/issue-self-study', [IssueSelfStudyController::class, 'index']);
        Route::post('/issue-self-study', [IssueSelfStudyController::class, 'store']);
        Route::get('/issue-self-study/{issueSelfStudy}', [IssueSelfStudyController::class, 'show']);
        Route::put('/issue-self-study/{issueSelfStudy}', [IssueSelfStudyController::class, 'update']);
        Route::delete('/issue-self-study/{issueSelfStudy}', [IssueSelfStudyController::class, 'destroy']);

        Route::get('/set-up-new-training', [SetUpNewTrainingController::class, 'index']);
        Route::post('/set-up-new-training', [SetUpNewTrainingController::class, 'store']);
        Route::get('/set-up-new-training/{setUpNewTraining}', [SetUpNewTrainingController::class, 'show']);
        Route::put('/set-up-new-training/{setUpNewTraining}', [SetUpNewTrainingController::class, 'update']);
        Route::delete('/set-up-new-training/{setUpNewTraining}', [SetUpNewTrainingController::class, 'destroy']);

        Route::get('/training-sessions', [TrainingSessionsController::class, 'index']);
        Route::post('/training-sessions', [TrainingSessionsController::class, 'store']);
        Route::get('/training-sessions/{trainingSession}', [TrainingSessionsController::class, 'show']);
        Route::put('/training-sessions/{trainingSession}', [TrainingSessionsController::class, 'update']);
        Route::delete('/training-sessions/{trainingSession}', [TrainingSessionsController::class, 'destroy']);
    });

    Route::prefix('/company-docs')->group(function () {
        Route::get('/document-manager', [DocumentManagerController::class, 'index']);
        Route::post('/document-manager', [DocumentManagerController::class, 'store']);
        Route::get('/document-manager/{documentManager}', [DocumentManagerController::class, 'show']);
        Route::put('/document-manager/{documentManager}', [DocumentManagerController::class, 'update']);
        Route::delete('/document-manager/{documentManager}', [DocumentManagerController::class, 'destroy']);

        Route::get('/team-document-manager', [TeamDocumentManagerController::class, 'index']);
        Route::post('/team-document-manager', [TeamDocumentManagerController::class, 'store']);
        Route::get('/team-document-manager/{teamDocumentManager}', [TeamDocumentManagerController::class, 'show']);
        Route::put('/team-document-manager/{teamDocumentManager}', [TeamDocumentManagerController::class, 'update']);
        Route::delete('/team-document-manager/{teamDocumentManager}', [TeamDocumentManagerController::class, 'destroy']);
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/dashboard', [DashboardController::class, 'store']);
    Route::get('/dashboard/{dashboard}', [DashboardController::class, 'show']);
    Route::put('/dashboard/{dashboard}', [DashboardController::class, 'update']);
    Route::delete('/dashboard/{dashboard}', [DashboardController::class, 'destroy']);

    Route::prefix('/management')->group(function () {
        Route::get('/users', [\App\Http\Controllers\BWPortal\Management\UsersController::class, 'index']);
        Route::post('/users', [\App\Http\Controllers\BWPortal\Management\UsersController::class, 'store']);
        Route::get('/users/{user}', [\App\Http\Controllers\BWPortal\Management\UsersController::class, 'show']);
        Route::put('/users/{user}', [\App\Http\Controllers\BWPortal\Management\UsersController::class, 'update']);
        Route::delete('/users/{user}', [\App\Http\Controllers\BWPortal\Management\UsersController::class, 'destroy']);

        Route::get('/user-audits', [UserAuditsController::class, 'index']);
        Route::post('/user-audits', [UserAuditsController::class, 'store']);
        Route::get('/user-audits/{userAudit}', [UserAuditsController::class, 'show']);
        Route::put('/user-audits/{userAudit}', [UserAuditsController::class, 'update']);
        Route::delete('/user-audits/{userAudit}', [UserAuditsController::class, 'destroy']);

        Route::get('/re-assign-tasks', [ReAssignTasksController::class, 'index']);
        Route::post('/re-assign-tasks', [ReAssignTasksController::class, 'store']);
        Route::get('/re-assign-tasks/{reAssignTask}', [ReAssignTasksController::class, 'show']);
        Route::put('/re-assign-tasks/{reAssignTask}', [ReAssignTasksController::class, 'update']);
        Route::delete('/re-assign-tasks/{reAssignTask}', [ReAssignTasksController::class, 'destroy']);

        Route::get('/team-holidays', [TeamHolidaysController::class, 'index']);
        Route::post('/team-holidays', [TeamHolidaysController::class, 'store']);
        Route::get('/team-holidays/{teamHoliday}', [TeamHolidaysController::class, 'show']);
        Route::put('/team-holidays/{teamHoliday}', [TeamHolidaysController::class, 'update']);
        Route::delete('/team-holidays/{teamHoliday}', [TeamHolidaysController::class, 'destroy']);

        Route::get('/hr-holidays', [HRHolidaysController::class, 'index']);
        Route::post('/hr-holidays', [HRHolidaysController::class, 'store']);
        Route::get('/hr-holidays/{hrHoliday}', [HRHolidaysController::class, 'show']);
        Route::put('/hr-holidays/{hrHoliday}', [HRHolidaysController::class, 'update']);
        Route::delete('/hr-holidays/{hrHoliday}', [HRHolidaysController::class, 'destroy']);

        Route::get('/starter-form', [StarterFormController::class, 'index']);
        Route::post('/starter-form', [StarterFormController::class, 'store']);
        Route::get('/starter-form/{starterForm}', [StarterFormController::class, 'show']);
        Route::put('/starter-form/{starterForm}', [StarterFormController::class, 'update']);
        Route::delete('/starter-form/{starterForm}', [StarterFormController::class, 'destroy']);
    });

    Route::prefix('/my-account')->group(function () {
        Route::get('/personal-information', [PersonalInformationController::class, 'index']);
        Route::post('/personal-information', [PersonalInformationController::class, 'store']);
        Route::get('/personal-information/{personalInformation}', [PersonalInformationController::class, 'show']);
        Route::put('/personal-information/{personalInformation}', [PersonalInformationController::class, 'update']);
        Route::delete('/personal-information/{personalInformation}', [PersonalInformationController::class, 'destroy']);

        Route::get('/cv', [CVController::class, 'index']);
        Route::post('/cv', [CVController::class, 'store']);
        Route::get('/cv/{cv}', [CVController::class, 'show']);
        Route::put('/cv/{cv}', [CVController::class, 'update']);
        Route::delete('/cv/{cv}', [CVController::class, 'destroy']);

        Route::get('/my-documents', [MyDocumentsController::class, 'index']);
        Route::post('/my-documents', [MyDocumentsController::class, 'store']);
        Route::get('/my-documents/{myDocuments}', [MyDocumentsController::class, 'show']);
        Route::put('/my-documents/{myDocuments}', [MyDocumentsController::class, 'update']);
        Route::delete('/my-documents/{myDocuments}', [MyDocumentsController::class, 'destroy']);

        Route::get('/holiday-requests', [HolidayRequestsController::class, 'index']);
        Route::post('/holiday-requests', [HolidayRequestsController::class, 'store']);
        Route::get('/holiday-requests/{holidayRequests}', [HolidayRequestsController::class, 'show']);
        Route::put('/holiday-requests/{holidayRequests}', [HolidayRequestsController::class, 'update']);
        Route::delete('/holiday-requests/{holidayRequests}', [HolidayRequestsController::class, 'destroy']);

        Route::get('/team-calendar', [TeamCalendarController::class, 'index']);
        Route::post('/team-calendar', [TeamCalendarController::class, 'store']);
        Route::get('/team-calendar/{teamCalendar}', [TeamCalendarController::class, 'show']);
        Route::put('/team-calendar/{teamCalendar}', [TeamCalendarController::class, 'update']);
        Route::delete('/team-calendar/{teamCalendar}', [TeamCalendarController::class, 'destroy']);
    });

    Route::prefix('/my-training')->group(function () {
        Route::get('/completed', [CompletedController::class, 'index']);
        Route::post('/completed', [CompletedController::class, 'store']);
        Route::get('/completed/{completed}', [CompletedController::class, 'show']);
        Route::put('/completed/{completed}', [CompletedController::class, 'update']);
        Route::delete('/completed/{completed}', [CompletedController::class, 'destroy']);

        Route::get('/session-history', [SessionHistoryController::class, 'index']);
        Route::post('/session-history', [SessionHistoryController::class, 'store']);
        Route::get('/session-history/{sessionHistory}', [SessionHistoryController::class, 'show']);
        Route::put('/session-history/{sessionHistory}', [SessionHistoryController::class, 'update']);
        Route::delete('/session-history/{sessionHistory}', [SessionHistoryController::class, 'destroy']);

        Route::get('/self-study-history', [SelfStudyHistoryController::class, 'index']);
        Route::post('/self-study-history', [SelfStudyHistoryController::class, 'store']);
        Route::get('/self-study-history/{selfStudyHistory}', [SelfStudyHistoryController::class, 'show']);
        Route::put('/self-study-history/{selfStudyHistory}', [SelfStudyHistoryController::class, 'update']);
        Route::delete('/self-study-history/{selfStudyHistory}', [SelfStudyHistoryController::class, 'destroy']);

        Route::get('/my-audits', [MyAuditsController::class, 'index']);
        Route::post('/my-audits', [MyAuditsController::class, 'store']);
        Route::get('/my-audits/{myAudits}', [MyAuditsController::class, 'show']);
        Route::put('/my-audits/{myAudits}', [MyAuditsController::class, 'update']);
        Route::delete('/my-audits/{myAudits}', [MyAuditsController::class, 'destroy']);
    });

    Route::prefix('/reports')->group(function () {
        Route::get('/session-history', [\App\Http\Controllers\BWPortal\Reports\SessionHistoryController::class, 'index']);
        Route::post('/session-history', [\App\Http\Controllers\BWPortal\Reports\SessionHistoryController::class, 'store']);
        Route::get('/session-history/{sessionHistory}', [\App\Http\Controllers\BWPortal\Reports\SessionHistoryController::class, 'show']);
        Route::put('/session-history/{sessionHistory}', [\App\Http\Controllers\BWPortal\Reports\SessionHistoryController::class, 'update']);
        Route::delete('/session-history/{sessionHistory}', [\App\Http\Controllers\BWPortal\Reports\SessionHistoryController::class, 'destroy']);

        Route::get('/training-history', [TrainingHistoryController::class, 'index']);
        Route::post('/training-history', [TrainingHistoryController::class, 'store']);
        Route::get('/training-history/{trainingHistory}', [TrainingHistoryController::class, 'show']);
        Route::put('/training-history/{trainingHistory}', [TrainingHistoryController::class, 'update']);
        Route::delete('/training-history/{trainingHistory}', [TrainingHistoryController::class, 'destroy']);

        Route::get('/employee-list', [EmployeeListController::class, 'index']);
        Route::post('/employee-list', [EmployeeListController::class, 'store']);
        Route::get('/employee-list/{employeeList}', [EmployeeListController::class, 'show']);
        Route::put('/employee-list/{employeeList}', [EmployeeListController::class, 'update']);
        Route::delete('/employee-list/{employeeList}', [EmployeeListController::class, 'destroy']);

        Route::get('/last-access', [LastAccessController::class, 'index']);
        Route::post('/last-access', [LastAccessController::class, 'store']);
        Route::get('/last-access/{lastAccess}', [LastAccessController::class, 'show']);
        Route::put('/last-access/{lastAccess}', [LastAccessController::class, 'update']);
        Route::delete('/last-access/{lastAccess}', [LastAccessController::class, 'destroy']);

        Route::get('/cpd-hours-report', [CPDHoursReportController::class, 'index']);
        Route::post('/cpd-hours-report', [CPDHoursReportController::class, 'store']);
        Route::get('/cpd-hours-report/{cpdHoursReport}', [CPDHoursReportController::class, 'show']);
        Route::put('/cpd-hours-report/{cpdHoursReport}', [CPDHoursReportController::class, 'update']);
        Route::delete('/cpd-hours-report/{cpdHoursReport}', [CPDHoursReportController::class, 'destroy']);

        Route::get('/self-study-outstanding-report', [SelfStudyOutstandingReportController::class, 'index']);
        Route::post('/self-study-outstanding-report', [SelfStudyOutstandingReportController::class, 'store']);
        Route::get('/self-study-outstanding-report/{selfStudyOutstandingReport}', [SelfStudyOutstandingReportController::class, 'show']);
        Route::put('/self-study-outstanding-report/{selfStudyOutstandingReport}', [SelfStudyOutstandingReportController::class, 'update']);
        Route::delete('/self-study-outstanding-report/{selfStudyOutstandingReport}', [SelfStudyOutstandingReportController::class, 'destroy']);

        Route::get('/training-and-self-study', [TrainingAndSelfStudyController::class, 'index']);
        Route::post('/training-and-self-study', [TrainingAndSelfStudyController::class, 'store']);
        Route::get('/training-and-self-study/{trainingAndSelfStudy}', [TrainingAndSelfStudyController::class, 'show']);
        Route::put('/training-and-self-study/{trainingAndSelfStudy}', [TrainingAndSelfStudyController::class, 'update']);
        Route::delete('/training-and-self-study/{trainingAndSelfStudy}', [TrainingAndSelfStudyController::class, 'destroy']);
    });

    Route::prefix('/training')->group(function () {
        Route::get('/set-up-new-training', [\App\Http\Controllers\BWPortal\Training\SetUpNewTrainingController::class, 'index']);
        Route::post('/set-up-new-training', [\App\Http\Controllers\BWPortal\Training\SetUpNewTrainingController::class, 'store']);
        Route::get('/set-up-new-training/{setUpNewTraining}', [\App\Http\Controllers\BWPortal\Training\SetUpNewTrainingController::class, 'show']);
        Route::put('/set-up-new-training/{setUpNewTraining}', [\App\Http\Controllers\BWPortal\Training\SetUpNewTrainingController::class, 'update']);
        Route::delete('/set-up-new-training/{setUpNewTraining}', [\App\Http\Controllers\BWPortal\Training\SetUpNewTrainingController::class, 'destroy']);

        Route::get('/training-sessions', [\App\Http\Controllers\BWPortal\Training\TrainingSessionsController::class, 'index']);
        Route::post('/training-sessions', [\App\Http\Controllers\BWPortal\Training\TrainingSessionsController::class, 'store']);
        Route::get('/training-sessions/{trainingSession}', [\App\Http\Controllers\BWPortal\Training\TrainingSessionsController::class, 'show']);
        Route::put('/training-sessions/{trainingSession}', [\App\Http\Controllers\BWPortal\Training\TrainingSessionsController::class, 'update']);
        Route::delete('/training-sessions/{trainingSession}', [\App\Http\Controllers\BWPortal\Training\TrainingSessionsController::class, 'destroy']);

        Route::get('/issue-self-study', [\App\Http\Controllers\BWPortal\Training\IssueSelfStudyController::class, 'index']);
        Route::post('/issue-self-study', [\App\Http\Controllers\BWPortal\Training\IssueSelfStudyController::class, 'store']);
        Route::get('/issue-self-study/{issueSelfStudy}', [\App\Http\Controllers\BWPortal\Training\IssueSelfStudyController::class, 'show']);
        Route::put('/issue-self-study/{issueSelfStudy}', [\App\Http\Controllers\BWPortal\Training\IssueSelfStudyController::class, 'update']);
        Route::delete('/issue-self-study/{issueSelfStudy}', [\App\Http\Controllers\BWPortal\Training\IssueSelfStudyController::class, 'destroy']);
    });
});
