<template>
    <div>
        <ul class="sideBarElements">
            <li @click="selectDashboard" :class="{ activeElement: dashboardActive }"
                @mouseover="dashboardIconActive = true" @mouseleave="dashboardIconActive = false">
                <img :src="dashboardIcon" alt="Dashboard"/>
                <p v-show="expandSideBar">Dashboard</p>
            </li>
            <li @click="selectMyTraining" :class="{ activeElement: myTrainingActive }"
                @mouseover="myTrainingIconActive = true" @mouseleave="myTrainingIconActive = false">
                <img :src="myTrainingIcon" alt="My Training"/>
                <p v-show="expandSideBar">My Training</p>
            </li>
            <li @click="selectManagement" :class="{ activeElement: managementActive }"
                @mouseover="managementIconActive = true" @mouseleave="managementIconActive = false">
                <img :src="managementIcon" alt="Management"/>
                <p v-show="expandSideBar">Management</p>
            </li>
            <li @click="selectTraining" :class="{ activeElement: trainingActive }"
                @mouseover="trainingIconActive = true" @mouseleave="trainingIconActive = false">
                <img :src="trainingIcon" alt="Training"/>
                <p v-show="expandSideBar">Training</p>
            </li>
            <li @click="selectAccount" :class="{ activeElement: accountActive }"
                @mouseover="accountIconActive = true" @mouseleave="accountIconActive = false">
                <img :src="accountIcon" alt="Account"/>
                <p v-show="expandSideBar">Account</p>
            </li>
            <li @click="selectReports" :class="{ activeElement: reportsActive }"
                @mouseover="reportsIconActive = true" @mouseleave="reportsIconActive = false">
                <img :src="reportsIcon" alt="Reports"/>
                <p v-show="expandSideBar">Reports</p>
            </li>
            <li @click="selectBWTrainings" :class="{ activeElement: bwTrainingsActive }"
                @mouseover="bwTrainingsIconActive = true" @mouseleave="bwTrainingsIconActive = false">
                <img :src="bwTrainingsIcon" alt="BW Trainings"/>
                <p v-show="expandSideBar">BW Trainings</p>
            </li>
            <li @click="selectMyAccount" :class="{ activeElement: myAccountActive }"
                @mouseover="myAccountIconActive = true" @mouseleave="myAccountIconActive = false">
                <img :src="myAccountIcon" alt="My Account"/>
                <p v-show="expandSideBar">My Account</p>
            </li>
            <li @click="selectCompanyDocs" :class="{ activeElement: companyDocsActive }"
                @mouseover="companyDocsIconActive = true" @mouseleave="companyDocsIconActive = false">
                <img :src="companyDocsIcon" alt="Company Docs"/>
                <p v-show="expandSideBar">Company Docs</p>
            </li>
            <li @click="selectLogout" :class="{ activeElement: logoutActive }"
                @mouseover="logoutIconActive = true" @mouseleave="logoutIconActive = false">
                <img :src="logoutIcon" alt="Logout"/>
                <p v-show="expandSideBar">Logout</p>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        expandSideBar: Boolean,
    },
    data() {
        return {
            accountActive: false,
            accountIconActive: false,
            accountIcon: this.$accountImgOff,

            bwTrainingsActive: false,
            bwTrainingsIconActive: false,
            bwTrainingsIcon: this.$bwTrainingsImgOff,

            companyDocsActive: false,
            companyDocsIconActive: false,
            companyDocsIcon: this.$companyDocsImgOff,

            dashboardActive: true,
            dashboardIconActive: true,
            dashboardIcon: this.$dashboardImgOn,

            managementActive: false,
            managementIconActive: false,
            managementIcon: this.$managementImgOff,

            myAccountActive: false,
            myAccountIconActive: false,
            myAccountIcon: this.$myAccountImgOff,

            myTrainingActive: false,
            myTrainingIconActive: false,
            myTrainingIcon: this.$myTrainingImgOff,

            reportsActive: false,
            reportsIconActive: false,
            reportsIcon: this.$reportsImgOff,

            trainingActive: false,
            trainingIconActive: false,
            trainingIcon: this.$trainingImgOff,

            logoutActive: false,
            logoutIconActive: false,
            logoutIcon: this.$logoutImgOff,
        }
    },
    watch: {
        accountIconActive(hover) {
            hover ? this.accountIcon = this.$accountImgOn :
                !this.accountActive ? this.accountIcon = this.$accountImgOff :
                    this.accountIcon = this.$accountImgOn;
        },
        bwTrainingsIconActive(hover) {
            hover ? this.bwTrainingsIcon = this.$bwTrainingsImgOn :
                !this.bwTrainingsActive ? this.bwTrainingsIcon = this.$bwTrainingsImgOff :
                    this.bwTrainingsIcon = this.$bwTrainingsImgOn;
        },
        companyDocsIconActive(hover) {
            hover ? this.companyDocsIcon = this.$companyDocsImgOn :
                !this.companyDocsActive ? this.companyDocsIcon = this.$companyDocsImgOff :
                    this.companyDocsIcon = this.$companyDocsImgOn;
        },
        dashboardIconActive(hover) {
            hover ? this.dashboardIcon = this.$dashboardImgOn :
                !this.dashboardActive ? this.dashboardIcon = this.$dashboardImgOff :
                    this.dashboardIcon = this.$dashboardImgOn;
        },
        managementIconActive(hover) {
            hover ? this.managementIcon = this.$managementImgOn :
                !this.managementActive ? this.managementIcon = this.$managementImgOff :
                    this.managementIcon = this.$managementImgOn;
        },
        myAccountIconActive(hover) {
            hover ? this.myAccountIcon = this.$myAccountImgOn :
                !this.myAccountActive ? this.myAccountIcon = this.$myAccountImgOff :
                    this.myAccountIcon = this.$myAccountImgOn;
        },
        myTrainingIconActive(hover) {
            hover ? this.myTrainingIcon = this.$myTrainingImgOn :
                !this.myTrainingActive ? this.myTrainingIcon = this.$myTrainingImgOff :
                    this.myTrainingIcon = this.$myTrainingImgOn;
        },
        reportsIconActive(hover) {
            hover ? this.reportsIcon = this.$reportsImgOn :
                !this.reportsActive ? this.reportsIcon = this.$reportsImgOff :
                    this.reportsIcon = this.$reportsImgOn;
        },
        trainingIconActive(hover) {
            hover ? this.trainingIcon = this.$trainingImgOn :
                !this.trainingActive ? this.trainingIcon = this.$trainingImgOff :
                    this.trainingIcon = this.$trainingImgOn;
        },
        logoutIconActive(hover) {
            hover ? this.logoutIcon = this.$logoutImgOn :
                !this.logoutActive ? this.logoutIcon = this.$logoutImgOff :
                    this.logoutIcon = this.$logoutImgOn;
        }
    },
    methods: {
        accountOff() {
            this.accountActive = false;
            this.accountIconActive = false;
            this.accountIcon = this.$accountImgOff;
        },
        bwTrainingsOff() {
            this.bwTrainingsActive = false;
            this.bwTrainingsIconActive = false;
            this.bwTrainingsIcon = this.$bwTrainingsImgOff;
        },
        companyDocsOff() {
            this.companyDocsActive = false;
            this.companyDocsIconActive = false;
            this.companyDocsIcon = this.$companyDocsImgOff;
        },
        dashboardOff() {
            this.dashboardActive = false;
            this.dashboardIconActive = false;
            this.dashboardIcon = this.$dashboardImgOff;
        },
        managementOff() {
            this.managementActive = false;
            this.managementIconActive = false;
            this.managementIcon = this.$managementImgOff;
        },
        myAccountOff() {
            this.myAccountActive = false;
            this.myAccountIconActive = false;
            this.myAccountIcon = this.$myAccountImgOff;
        },
        myTrainingOff() {
            this.myTrainingActive = false;
            this.myTrainingIconActive = false;
            this.myTrainingIcon = this.$myTrainingImgOff;
        },
        reportsOff() {
            this.reportsActive = false;
            this.reportsIconActive = false;
            this.reportsIcon = this.$reportsImgOff;
        },
        trainingOff() {
            this.trainingActive = false;
            this.trainingIconActive = false;
            this.trainingIcon = this.$trainingImgOff;
        },
        selectAccount() {
            this.bwTrainingsOff();
            this.companyDocsOff();
            this.dashboardOff();
            this.managementOff();
            this.myAccountOff();
            this.myTrainingOff();
            this.reportsOff();
            this.trainingOff();
            this.accountActive = true;
            this.accountIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$accountView
            });
        },
        selectBWTrainings() {
            this.accountOff();
            this.companyDocsOff();
            this.dashboardOff();
            this.managementOff();
            this.myAccountOff();
            this.myTrainingOff();
            this.reportsOff();
            this.trainingOff();
            this.bwTrainingsActive = true;
            this.bwTrainingsIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$bwTrainingsView
            });
        },
        selectCompanyDocs() {
            this.accountOff();
            this.bwTrainingsOff();
            this.dashboardOff();
            this.managementOff();
            this.myAccountOff();
            this.myTrainingOff();
            this.reportsOff();
            this.trainingOff();
            this.companyDocsActive = true;
            this.companyDocsIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$companyDocsView
            });
        },
        selectDashboard() {
            this.accountOff();
            this.bwTrainingsOff();
            this.companyDocsOff();
            this.managementOff();
            this.myAccountOff();
            this.myTrainingOff();
            this.reportsOff();
            this.trainingOff();
            this.dashboardActive = true;
            this.dashboardIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$dashboardView
            });
        },
        selectManagement() {
            this.accountOff();
            this.bwTrainingsOff();
            this.companyDocsOff();
            this.dashboardOff();
            this.myAccountOff();
            this.myTrainingOff();
            this.reportsOff();
            this.trainingOff();
            this.managementActive = true;
            this.managementIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$managementView
            });
        },
        selectMyAccount() {
            this.accountOff();
            this.bwTrainingsOff();
            this.companyDocsOff();
            this.dashboardOff();
            this.managementOff();
            this.myTrainingOff();
            this.reportsOff();
            this.trainingOff();
            this.myAccountActive = true;
            this.myAccountIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$myAccountView
            });
        },
        selectMyTraining() {
            this.accountOff();
            this.bwTrainingsOff();
            this.companyDocsOff();
            this.dashboardOff();
            this.managementOff();
            this.myAccountOff();
            this.reportsOff();
            this.trainingOff();
            this.myTrainingActive = true;
            this.myTrainingIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$myTrainingView
            });
        },
        selectReports() {
            this.accountOff();
            this.bwTrainingsOff();
            this.companyDocsOff();
            this.dashboardOff();
            this.managementOff();
            this.myAccountOff();
            this.myTrainingOff();
            this.trainingOff();
            this.reportsActive = true;
            this.reportsIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$reportsView
            });
        },
        selectTraining() {
            this.accountOff();
            this.bwTrainingsOff();
            this.companyDocsOff();
            this.dashboardOff();
            this.managementOff();
            this.myAccountOff();
            this.myTrainingOff();
            this.reportsOff();
            this.trainingActive = true;
            this.trainingIconActive = true;
            this.$router.push({
                path: this.$bwPortalView + this.$trainingView
            });
        },
        selectLogout() {
            this.$router.push({
                path: this.$login
            });

            axios.get('/logout', {
                headers: {"Authorization": `Bearer ${this.$session.bearer_token}`}
            }).then(response => {
                localStorage.removeItem('session');
            });
        }
    }
}
</script>
