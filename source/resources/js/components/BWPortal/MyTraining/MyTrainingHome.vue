<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">My Training</h2>
                    </div>
                    <div class="card-container">
                        <div @click="selectCompleted" class="orange-tile mt-5">
                            <h4 class="card-title">Completed</h4>
                        </div>
                        <div @click="selectSessionHistory" class="green-tile">
                            <h4 class="card-title">Session History</h4>
                        </div>
                        <div @click="selectSelfStudyHistory" class="teal-tile">
                            <h4 class="card-title">Self Study History</h4>
                        </div>
                        <div @click="selectMyAudits" class="purple-tile">
                            <h4 class="card-title">My Audits</h4>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
import Completed from "./Completed";
import SessionHistory from "./SessionHistory";
import SelfStudyHistory from "./SelfStudyHistory";
import MyAudits from "./MyAudits";

export default {
    name: "MyTrainingHome",
    components: {
        Completed,
        SessionHistory,
        SelfStudyHistory,
        MyAudits
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        selectCompleted() {
            this.$router.push({
                path: this.$bwPortalView + this.$myTrainingView + '/completed'
            });
        },
        selectSessionHistory() {
            this.$router.push({
                path: this.$bwPortalView + this.$myTrainingView + '/session-history'
            });
        },
        selectSelfStudyHistory() {
            this.$router.push({
                path: this.$bwPortalView + this.$myTrainingView + '/self-study-history'
            });
        },
        selectMyAudits() {
            this.$router.push({
                path: this.$bwPortalView + this.$myTrainingView + '/my-audits'
            });
        }
    }
}
</script>
