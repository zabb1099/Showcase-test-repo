// Vue Router

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//-------- BW Portal - Account Routes --------//
import AccountHomeBWPortal from "./components/BWPortal/Account/AccountHome";
import AccountUsersBWPortal from "./components/BWPortal/Account/Users";
import AccountUsersAdminBWPortal from "./components/BWPortal/Account/UsersAdmin";
import AccountUserGroupsBWPortal from "./components/BWPortal/Account/UserGroups";
import AccountNewUserFormBWPortal from "./components/BWPortal/Account/NewUserForm";
import AccountQuestTemplatesBWPortal from "./components/BWPortal/Account/QuestTemplates";

//-------- BW Portal - BW Trainings Routes --------//
import BWTrainingsHomeBWPortal from "./components/BWPortal/BWTrainings/BWTrainingsHome";
import BWTrainingsSetUpNewTrainingBWPortal from "./components/BWPortal/BWTrainings/SetUpNewTraining";
import BWTrainingsTrainingSessionsBWPortal from "./components/BWPortal/BWTrainings/TrainingSessions";
import BWTrainingsIssueSelfStudyBWPortal from "./components/BWPortal/BWTrainings/IssueSelfStudy";

//-------- BW Portal - Company Docs Routes --------//
import CompanyDocsHomeBWPortal from "./components/BWPortal/CompanyDocs/CompanyDocsHome";
import CompanyDocsDocumentManagerBWPortal from "./components/BWPortal/CompanyDocs/DocumentManager";
import CompanyDocsTeamDocumentManagerBWPortal from "./components/BWPortal/CompanyDocs/TeamDocumentManager";

//-------- BW Portal - Dashboard Routes --------//
import DashboardHomeBWPortal from "./components/BWPortal/Dashboard/DashboardHome";

//-------- BW Portal - Management Routes --------//
import ManagementHomeBWPortal from "./components/BWPortal/Management/ManagementHome";
import ManagementUsersBWPortal from "./components/BWPortal/Management/Users";
import ManagementUserAuditsBWPortal from "./components/BWPortal/Management/UserAudits";
import ManagementReAssignTasksBWPortal from "./components/BWPortal/Management/ReAssignTasks";
import ManagementTeamHolidaysBWPortal from "./components/BWPortal/Management/TeamHolidays";
import ManagementHRHolidaysBWPortal from "./components/BWPortal/Management/HRHolidays";
import ManagementStarterFormBWPortal from "./components/BWPortal/Management/StarterForm";

//-------- BW Portal - My Account Routes --------//
import MyAccountHomeBWPortal from "./components/BWPortal/MyAccount/MyAccountHome";
import MyAccountPersonalInformationBWPortal from "./components/BWPortal/MyAccount/PersonalInformation";
import MyAccountCVBWPortal from "./components/BWPortal/MyAccount/CV";
import MyAccountMyDocumentsBWPortal from "./components/BWPortal/MyAccount/MyDocuments";
import MyAccountHolidayRequestsBWPortal from "./components/BWPortal/MyAccount/HolidayRequests";
import MyAccountTeamCalendarBWPortal from "./components/BWPortal/MyAccount/TeamCalendar";

//-------- BW Portal - My Training Routes --------//
import MyTrainingHomeBWPortal from "./components/BWPortal/MyTraining/MyTrainingHome";
import MyTrainingCompletedBWPortal from "./components/BWPortal/MyTraining/Completed";
import MyTrainingSessionHistoryBWPortal from "./components/BWPortal/MyTraining/SessionHistory";
import MyTrainingSelfStudyHistoryBWPortal from "./components/BWPortal/MyTraining/SelfStudyHistory";
import MyTrainingMyAuditsBWPortal from "./components/BWPortal/MyTraining/MyAudits";

//-------- BW Portal - Reports Routes --------//
import ReportsHomeBWPortal from "./components/BWPortal/Reports/ReportsHome";
import ReportsSessionHistoryBWPortal from "./components/BWPortal/Reports/SessionHistory";
import ReportsTrainingHistoryBWPortal from "./components/BWPortal/Reports/TrainingHistory";
import ReportsEmployeeListBWPortal from "./components/BWPortal/Reports/EmployeeList";
import ReportsLastAccessBWPortal from "./components/BWPortal/Reports/LastAccess";
import ReportsCPDHoursReportBWPortal from "./components/BWPortal/Reports/CPDHoursReport";
import ReportsSelfStudyOutstandingReportBWPortal from "./components/BWPortal/Reports/SelfStudyOutstandingReport";
import ReportsTrainingAndSelfStudyBWPortal from "./components/BWPortal/Reports/TrainingAndSelfStudy";

//-------- BW Portal - Training Routes --------//
import TrainingHomeBWPortal from "./components/BWPortal/Training/TrainingHome";
import TrainingSetUpNewTrainingBWPortal from "./components/BWPortal/Training/SetUpNewTraining";
import TrainingTrainingSessionsBWPortal from "./components/BWPortal/Training/TrainingSessions";
import TrainingIssueSelfStudyBWPortal from "./components/BWPortal/Training/IssueSelfStudy";

// IT Portal Components
import knowledgeBaseHomeITPortal from "./components/ITPortal/KnowledgeBase/KnowledgeBaseHome";
import OfficeUserHomeITPortal from "./components/ITPortal/OfficeUsers/OfficeUsersHome";
import AssetRegisterHomeITPortal from "./components/ITPortal/AssetRegister/AssetRegisterHome";
import UserStationsHomeITPortal from "./components/ITPortal/UserStations/UserStationsHome";
import DevSupportJobsHomeITPortal from "./components/ITPortal/DevSupportJobs/DevSupportJobsHome";
import PrintQueuesHomeITPortal from "./components/ITPortal/PrintQueues/PrintQueuesHome";
import NoticeBoardHome from "./components/ITPortal/ITNotices/NoticeBoardHome";

import topNavbar from "./components/Navigation/Navbar/NavbarHome";
import sidebar from "./components/Navigation/Sidebar/SidebarHome";
import Login from "./components/Login/Login";
import PageNotFound from './components/PageNotFound/PageNotFound';

function isLoggedIn() {
    let storageItem = localStorage.getItem('session');
    if (storageItem !== undefined && storageItem !== null) {
        let session = JSON.parse(storageItem);
        if (session.bearer_token !== undefined) {
            Vue.prototype.$session = JSON.parse(localStorage.getItem('session'));
            return true
        }
    }
    return false;
}

const routes = [
    {
        path: '/',
        component: Login
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    //-------- IT Portal Routes --------//
    {
        path: '/it-portal',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: knowledgeBaseHomeITPortal,
            sidebar: sidebar.constructor,
            topNavbar: topNavbar,
        }
    },
    {
        path: '/it-portal/knowledge-base',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: knowledgeBaseHomeITPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        },
        name: 'Knowledge Base'
    },
    {
        path: '/it-portal/office-users',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: OfficeUserHomeITPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        },
        name: 'Office Users'
    },
    {
        path: '/it-portal/asset-register',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: AssetRegisterHomeITPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        },
        name: 'Asset Register'
    },
    {
        path: '/it-portal/user-stations',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: UserStationsHomeITPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        },
        name: 'User Stations'
    },
    {
        path: '/it-portal/dev-support-jobs',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: DevSupportJobsHomeITPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        },
        name: 'Dev Support Jobs'
    },
    {
        path: '/it-portal/print-queues',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: PrintQueuesHomeITPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        },
        name: 'Print Queues'
    },
    {
        path: '/it-portal/it-notices',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: NoticeBoardHome,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - Account Routes --------//
    {
        path: '/bw-portal',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: DashboardHomeBWPortal,
            sidebar: sidebar.constructor,
            topNavbar: topNavbar,
        }
    },
    {
        path: '/bw-portal/account',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: AccountHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/account/users',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: AccountUsersBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/account/users-admin',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: AccountUsersAdminBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/account/user-groups',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: AccountUserGroupsBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/account/new-user-form',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: AccountNewUserFormBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/account/quest-templates',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: AccountQuestTemplatesBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - BW Trainings Routes --------//
    {
        path: '/bw-portal/bw-trainings',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: BWTrainingsHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/bw-trainings/set-up-new-training',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: BWTrainingsSetUpNewTrainingBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/bw-trainings/training-sessions',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: BWTrainingsTrainingSessionsBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/bw-trainings/issue-self-study',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: BWTrainingsIssueSelfStudyBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - Company Docs Routes --------//
    {
        path: '/bw-portal/company-docs',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: CompanyDocsHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/company-docs/document-manager',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: CompanyDocsDocumentManagerBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/company-docs/team-document-manager',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: CompanyDocsTeamDocumentManagerBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - Dashboard Routes --------//
    {
        path: '/bw-portal/dashboard',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: DashboardHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - Management Routes --------//
    {
        path: '/bw-portal/management',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ManagementHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/management/users',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ManagementUsersBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/management/user-audits',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ManagementUserAuditsBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/management/re-assign-tasks',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ManagementReAssignTasksBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/management/team-holidays',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ManagementTeamHolidaysBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/management/hr-holidays',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ManagementHRHolidaysBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/management/starter-form',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ManagementStarterFormBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - My Account Routes --------//
    {
        path: '/bw-portal/my-account',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyAccountHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-account/personal-information',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyAccountPersonalInformationBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-account/cv',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyAccountCVBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-account/my-documents',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyAccountMyDocumentsBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-account/holiday-requests',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyAccountHolidayRequestsBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-account/team-calendar',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyAccountTeamCalendarBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - My Training Routes --------//
    {
        path: '/bw-portal/my-training',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyTrainingHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-training/completed',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyTrainingCompletedBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-training/session-history',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyTrainingSessionHistoryBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-training/self-study-history',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyTrainingSelfStudyHistoryBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/my-training/my-audits',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: MyTrainingMyAuditsBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - Reports Routes --------//
    {
        path: '/bw-portal/reports',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ReportsHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/reports/session-history',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ReportsSessionHistoryBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/reports/training-history',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ReportsTrainingHistoryBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/reports/employee-list',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ReportsEmployeeListBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/reports/last-access',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ReportsLastAccessBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/reports/cpd-hours-report',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ReportsCPDHoursReportBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/reports/self-study-outstanding-report',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ReportsSelfStudyOutstandingReportBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/reports/training-and-self-study',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: ReportsTrainingAndSelfStudyBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    //-------- BW Portal - Training Routes --------//
    {
        path: '/bw-portal/training',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: TrainingHomeBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/training/set-up-new-training',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: TrainingSetUpNewTrainingBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/training/training-sessions',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: TrainingTrainingSessionsBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: '/bw-portal/training/issue-self-study',
        beforeEnter: (to, from, next) => {
            if (!isLoggedIn()) next({
                name: 'login'
            });
            else next();
        },
        components: {
            default: TrainingIssueSelfStudyBWPortal,
            sidebar: sidebar,
            topNavbar: topNavbar
        }
    },
    {
        path: "*",
        component: PageNotFound
    }
]

export const router = new VueRouter({
    mode: 'history',
    routes
})

