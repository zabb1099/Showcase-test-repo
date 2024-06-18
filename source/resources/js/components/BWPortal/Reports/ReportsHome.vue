<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">Reports</h2>
                    </div>
                    <div class="card-container">
                        <div @click="selectSessionHistory" class="orange-tile mt-5">
                            <h4 class="card-title">Session History</h4>
                        </div>
                        <div @click="selectTrainingHistory" class="green-tile">
                            <h4 class="card-title">Training History</h4>
                        </div>
                        <div @click="selectEmployeeList" class="teal-tile">
                            <h4 class="card-title">Employee List</h4>
                        </div>
                        <div @click="selectLastAccess" class="purple-tile">
                            <h4 class="card-title">Last Access</h4>
                        </div>
                        <div @click="selectCPDHoursReport" class="orange-tile">
                            <h4 class="card-title">CPD Hours Report</h4>
                        </div>
                        <div @click="selectSelfStudyOutstandingReport" class="green-tile">
                            <h4 class="card-title">Self-Study Outstanding Report</h4>
                        </div>
                        <div @click="selectTrainingAndSelfStudy" class="teal-tile">
                            <h4 class="card-title">Training and Self-Study</h4>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
import SessionHistory from "./SessionHistory";
import TrainingHistory from "./TrainingHistory";
import EmployeeList from "./EmployeeList";
import LastAccess from "./LastAccess";
import CPDHoursReport from "./CPDHoursReport";
import SelfStudyOutstandingReport from "./SelfStudyOutstandingReport";
import TrainingAndSelfStudy from "./TrainingAndSelfStudy";

export default {
    name: "ReportsHome",
    components: {
        SessionHistory,
        TrainingHistory,
        EmployeeList,
        LastAccess,
        CPDHoursReport,
        SelfStudyOutstandingReport,
        TrainingAndSelfStudy
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        selectSessionHistory() {
            this.$router.push({
                path: this.$bwPortalView + this.$reportsView + '/session-history'
            });
        },
        selectTrainingHistory() {
            this.$router.push({
                path: this.$bwPortalView + this.$reportsView + '/training-history'
            });
        },
        selectEmployeeList() {
            this.$router.push({
                path: this.$bwPortalView + this.$reportsView + '/employee-list'
            });
        },
        selectLastAccess() {
            this.$router.push({
                path: this.$bwPortalView + this.$reportsView + '/last-access'
            });
        },
        selectCPDHoursReport() {
            this.$router.push({
                path: this.$bwPortalView + this.$reportsView + '/cpd-hours-report'
            });
        },
        selectSelfStudyOutstandingReport() {
            this.$router.push({
                path: this.$bwPortalView + this.$reportsView + '/self-study-outstanding-report'
            });
        },
        selectTrainingAndSelfStudy() {
            this.$router.push({
                path: this.$bwPortalView + this.$reportsView + '/training-and-self-study'
            });
        }
    }
}
</script>
