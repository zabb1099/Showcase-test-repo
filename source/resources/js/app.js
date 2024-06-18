//import {router} from "./router";

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue'
import {
    BootstrapVue,
    IconsPlugin
} from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)


//-------- Vue Sweet Alert Package --------//
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

//-------- Vuelidate Package --------//
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate)

//-------- Global Variables --------//

// URL Global Variables
Vue.prototype.$baseUrl = process.env.MIX_VUE_BASE_URL;
Vue.prototype.$knowledgeBaseUrl = '/api/it-portal/knowledge-base';
Vue.prototype.$officeUsersUrl = '/api/it-portal/office-users';
Vue.prototype.$assetRegisterUrl = '/api/it-portal/asset-register';
Vue.prototype.$userStationsUrl = '/api/it-portal/user-stations';
Vue.prototype.$devSupportJobsUrl = '/api/it-portal/dev-support-jobs';
Vue.prototype.$printQueuesUrl = '/api/it-portal/print-queues';
Vue.prototype.$userInformationUrl = '/api/user';
Vue.prototype.$noticeBoardUrl = '/api/it-portal/it-notices';
Vue.prototype.$apiUrl = '/api';

// View Global Variables
Vue.prototype.$login = '/login';
Vue.prototype.$itPortalView = '/it-portal';
Vue.prototype.$bwPortalView = '/bw-portal';
Vue.prototype.$qaPortalView = '/qa-portal';

// BW Portal View Global Variables
Vue.prototype.$accountView = '/account';
Vue.prototype.$bwTrainingsView = '/bw-trainings';
Vue.prototype.$companyDocsView = '/company-docs';
Vue.prototype.$dashboardView = '/dashboard';
Vue.prototype.$managementView = '/management';
Vue.prototype.$myAccountView = '/my-account';
Vue.prototype.$myTrainingView = '/my-training';
Vue.prototype.$reportsView = '/reports';
Vue.prototype.$trainingView = '/training';

// IT Portal View Global Variables
Vue.prototype.$knowledgeBaseView = '/knowledge-base';
Vue.prototype.$officeUsersView = '/office-users';
Vue.prototype.$assetRegisterView = '/asset-register';
Vue.prototype.$userStationsView = '/user-stations';
Vue.prototype.$devSupportJobsView = '/dev-support-jobs';
Vue.prototype.$itNoticesView = '/it-notices';

// IT Portal - Dev-Support Jobs - View Global Variables
Vue.prototype.$unlockClientFileView = '/unlock-client-file';
Vue.prototype.$fssView = '/fss';
Vue.prototype.$debtsolvDmView = '/dm-debtsolv';
Vue.prototype.$debtsolvIvaView = '/iva-debtsolv';
Vue.prototype.$leadsView = '/leads';
Vue.prototype.$ivaBondView = '/iva-bond';
Vue.prototype.$ivaMeetingView = '/iva-meeting';
Vue.prototype.$removeDuplicateBond = '/remove-duplicate-bond';
Vue.prototype.$processPayoutView = '/process-payout';
Vue.prototype.$newBACSCreditorView = '/new-bacs-creditor';
Vue.prototype.$testCaseFileView = '/test-case-file';
Vue.prototype.$bondRenewalDate = '/bond-renewal-date';
Vue.prototype.$removeSecondMeeting = '/remove-second-meeting';
Vue.prototype.$meetingOutcome = '/meeting-outcome';
Vue.prototype.$meetingOutcomeType = '/meeting-outcome-type';
Vue.prototype.$leadsUser = '/leads-user';
Vue.prototype.$createPhoenixLogin = '/create-phoenix-login';
Vue.prototype.$deletePhoenixLogin = '/delete-phoenix-login';
Vue.prototype.$xmlGeneration = '/generate-xml';
Vue.prototype.$isRX1Required = '/is-rx1-required';
Vue.prototype.$leadDisposition = '/lead-dispositions';
Vue.prototype.$historyDisposition = '/update-history';
Vue.prototype.$historyAssigned = '/update-history-assigned';
Vue.prototype.$assignedDisposition = '/delete-assigned';
Vue.prototype.$updateAssigned = '/update-assigned';
Vue.prototype.$historyVerified = '/update-history-verified';
Vue.prototype.$clientType = '/client-type';
Vue.prototype.$clientStatus = '/client-status';
Vue.prototype.$fssUser = '/fss-user';
Vue.prototype.$updateBFGPortalLogin = '/update-bfg-portal-login';
Vue.prototype.$deleteBFGPortalLogin = '/delete-bfg-portal-login';
Vue.prototype.$bulkCreditor = '/bulk-creditor';
Vue.prototype.$cardPayment = '/card-payment';
Vue.prototype.$duplicateFile = '/duplicate-file';

// IT Portal - Print Queues - View Global Variables
Vue.prototype.$printQueuesView = '/print-queues';
Vue.prototype.$ssrsView = '/ssrs';

// Images Global Variables
Vue.prototype.$itPortalImages = '/images/ITPortal';
Vue.prototype.$qaPortalImages = '/images/QAPortal';
Vue.prototype.$bwPortalImages = '/images/BWPortal';
Vue.prototype.$sharedImages = '/images/SharedImages';
Vue.prototype.$sideBarImages = '/images/SideBar';
Vue.prototype.$topNavBarImages = '/images/TopNavBar';
Vue.prototype.$loginImages = '/images/Login';

// BW Portal SideBar Images Global Variables
Vue.prototype.$accountImgOff = '/images/SideBar/knowledge-base_off.svg';
Vue.prototype.$accountImgOn = '/images/SideBar/knowledge-base_on.svg';
Vue.prototype.$bwTrainingsImgOff = '/images/SideBar/office-users_off.svg';
Vue.prototype.$bwTrainingsImgOn = '/images/SideBar/office-users_on.svg';
Vue.prototype.$companyDocsImgOff = '/images/SideBar/asset-register_off.svg';
Vue.prototype.$companyDocsImgOn = '/images/SideBar/asset-register_on.svg';
Vue.prototype.$dashboardImgOff = '/images/SideBar/user-stations_off.svg';
Vue.prototype.$dashboardImgOn = '/images/SideBar/user-stations_on.svg';
Vue.prototype.$managementImgOff = '/images/SideBar/it-assets_off.svg';
Vue.prototype.$managementImgOn = '/images/SideBar/it-assets_on.svg';
Vue.prototype.$myAccountImgOff = '/images/SideBar/knowledge-base_off.svg';
Vue.prototype.$myAccountImgOn = '/images/SideBar/knowledge-base_on.svg';
Vue.prototype.$myTrainingImgOff = '/images/SideBar/office-users_off.svg';
Vue.prototype.$myTrainingImgOn = '/images/SideBar/office-users_on.svg';
Vue.prototype.$reportsImgOff = '/images/SideBar/asset-register_off.svg';
Vue.prototype.$reportsImgOn = '/images/SideBar/asset-register_on.svg';
Vue.prototype.$trainingImgOff = '/images/SideBar/user-stations_off.svg';
Vue.prototype.$trainingImgOn = '/images/SideBar/user-stations_on.svg';
Vue.prototype.$logoutImgOff = '/images/SideBar/log-out_off.svg';
Vue.prototype.$logoutImgOn = '/images/SideBar/log-out_on.svg';

// IT Portal SideBar Images Global Variables
Vue.prototype.$knowledgeBaseImgOff = '/images/SideBar/knowledge-base_off.svg';
Vue.prototype.$knowledgeBaseImgOn = '/images/SideBar/knowledge-base_on.svg';
Vue.prototype.$officeUsersImgOff = '/images/SideBar/office-users_off.svg';
Vue.prototype.$officeUsersImgOn = '/images/SideBar/office-users_on.svg';
Vue.prototype.$assetRegisterImgOff = '/images/SideBar/asset-register_off.svg';
Vue.prototype.$assetRegisterImgOn = '/images/SideBar/asset-register_on.svg';
Vue.prototype.$userStationsImgOff = '/images/SideBar/user-stations_off.svg';
Vue.prototype.$userStationsImgOn = '/images/SideBar/user-stations_on.svg';
Vue.prototype.$itNoticesImgOff = '/images/SideBar/asset-register_off.svg';
Vue.prototype.$itNoticesImgOn = '/images/SideBar/asset-register_on.svg';
Vue.prototype.$devSupportJobsImgOff = '/images/SideBar/it-assets_off.svg';
Vue.prototype.$devSupportJobsImgOn = '/images/SideBar/it-assets_on.svg';
Vue.prototype.$printQueuesImgOff = '/images/SideBar/asset-register_off.svg';
Vue.prototype.$printQueuesImgOn = '/images/SideBar/asset-register_on.svg';
Vue.prototype.$logoutImgOff = '/images/SideBar/log-out_off.svg';
Vue.prototype.$logoutImgOn = '/images/SideBar/log-out_on.svg';

// Validation Global Variables
Vue.prototype.$requiredText = 'Field is required';
Vue.prototype.$emailText = 'Email address required';
Vue.prototype.$dateFormatText = 'Format required: YYYY-MM-DD';

// Session Global Variables
Vue.prototype.$session = JSON.parse(localStorage.getItem('session'));


//-------- Login/Logout & Refresh Token --------//
window.isRefreshing = false;
window.isLoggingOut = false;
window.canRefresh = 0;
window.counterInterval = null;

function isLoggedIn() {
    let storageItem = localStorage.getItem('session');
    if (storageItem !== undefined && storageItem !== null) {
        let session = JSON.parse(storageItem);
        if (session.bearer_token !== undefined) {
            return true;
        }
    }
    return false;
}

router.beforeEach((to, from, next) => {
    if (to.name !== 'login' && !isLoggedIn()) {
        next({
            name: 'login',
            replace: true
        });
        localStorage.removeItem('session');
    } else {
        if (JSON.parse(localStorage.getItem('session')) !== null && !window.isLoggingOut) {
            if (withinLast25Percent()) {
                window.canRefresh++;
            }
            countdown();
        }
        next();
    }
})

window.axios.interceptors.response.use(function (response) {
    if (localStorage.getItem('session') !== null && withinLast25Percent()) {
        window.canRefresh++;
    }
    return response;
}, function (error) {
    if (401 === error.response.status) {
        localStorage.removeItem('session');
        window.location = '/login';
    }
    return Promise.reject(error);
});

function withinLast25Percent() {
    let session = JSON.parse(localStorage.getItem('session'));
    let sessionExpiryTime = session.counter;
    let expiresInMilliseconds = session.expires_in * 1000;
    let timeToRefreshToken = (expiresInMilliseconds * 75) / 100;
    let currentTime = new Date().getTime();
    let differenceBetweenCurrentTimeAndExpiryTime = currentTime - sessionExpiryTime;

    return differenceBetweenCurrentTimeAndExpiryTime > timeToRefreshToken;
}

function countdown() {
    if (localStorage.getItem('session') !== null && !window.isLoggingOut) {
        window.counterInterval = setInterval(() => {
            let session = JSON.parse(localStorage.getItem('session'));
            let sessionExpiryTime = session.counter;
            let expiresInMilliseconds = session.expires_in * 1000;
            let timeToRefreshToken = (expiresInMilliseconds * 75) / 100;
            let currentTime = new Date().getTime();
            let differenceBetweenCurrentTimeAndExpiryTime = currentTime - sessionExpiryTime;

            handleRefreshToken(session, timeToRefreshToken, expiresInMilliseconds, differenceBetweenCurrentTimeAndExpiryTime);
        }, 60000);
    }
}

function handleRefreshToken(session, timeToRefreshToken, expiresInMilliseconds, differenceBetweenCurrentTimeAndExpiryTime) {
    if (differenceBetweenCurrentTimeAndExpiryTime > timeToRefreshToken) {
        if (!window.isRefreshing) {
            window.canRefresh > 0 ? handleRefreshTokenRequest(session) : logoutSession((expiresInMilliseconds - 8000), differenceBetweenCurrentTimeAndExpiryTime);
        }
    }
}

function handleRefreshTokenRequest(session) {
    let refreshToken = session.refresh_token;
    let requestPayload = {
        grant_type: 'refresh_token',
        refresh_token: refreshToken,
        client_id: process.env.MIX_VUE_APP_CLIENT_ID,
        client_secret: process.env.MIX_VUE_APP_CLIENT_SECRET,
        scope: '*'
    };

    window.isRefreshing = true;

    axios.post('/oauth/token', requestPayload)
        .then(response => {
            let newAccessToken = {
                USR_Full_Name: session.USR_Full_Name,
                USR_ID: session.USR_ID,
                bearer_token: response.data.access_token,
                UST_ID: session.UST_ID,
                USR_Unlimited: session.USR_Unlimited,
                expires_in: response.data.expires_in,
                refresh_token: response.data.refresh_token,
                counter: new Date().getTime()
            };

            localStorage.removeItem('session');
            localStorage.setItem('session', JSON.stringify(newAccessToken));
            window.isRefreshing = false;
            window.canRefresh = 0;
        })
        .catch(error => {

        })
        .finally(() => {
            window.isRefreshing = false;
            window.canRefresh = 0;
        });
}

function logoutSession(timeToLogout, differenceBetweenCurrentTimeAndExpiryTime) {
    let session = JSON.parse(localStorage.getItem('session'));
    if (session !== null) {
        if (differenceBetweenCurrentTimeAndExpiryTime >= timeToLogout && !window.isLoggingOut) {
            window.isLoggingOut = true;
            clearInterval(window.counterInterval);
            axios.get('/logout', {
                headers: {"Authorization": `Bearer ${session.bearer_token}`}
            }).then(response => {
                localStorage.removeItem('session');
            }).catch(error => {

            }).finally(() => {
                window.location = '/login';
                setTimeout(() => {
                    window.isLoggingOut = false;
                }, 8000);
            });
        }
    }
}

//-------- Vue Router --------//

import {router} from './router';

// Component to initialize the project
import App from './components/App'
import Login from "./components/Login/Login";

const app = new Vue({
    el: '#app',
    components: {
        App,
        Login
    },
    router,
});
