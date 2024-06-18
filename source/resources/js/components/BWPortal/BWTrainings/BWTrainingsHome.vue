<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">BW Trainings</h2>
                    </div>
                    <div class="card-container">
                        <div @click="selectSetUpNewTraining" class="orange-tile mt-5">
                            <h4 class="card-title">Set Up New Training</h4>
                        </div>
                        <div @click="selectTrainingSessions" class="green-tile">
                            <h4 class="card-title">Training Sessions</h4>
                        </div>
                        <div @click="selectIssueSelfStudy" class="teal-tile">
                            <h4 class="card-title">Issue Self Study</h4>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
import SetUpNewTraining from "./SetUpNewTraining";
import TrainingSessions from "./TrainingSessions";
import IssueSelfStudy from "./IssueSelfStudy";

export default {
    name: "BWTrainingsHome",
    components: {
        SetUpNewTraining,
        TrainingSessions,
        IssueSelfStudy
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        selectSetUpNewTraining() {
            this.$router.push({
                path: this.$bwPortalView + this.$bwTrainingsView + '/set-up-new-training'
            });
        },
        selectTrainingSessions() {
            this.$router.push({
                path: this.$bwPortalView + this.$bwTrainingsView + '/training-sessions'
            });
        },
        selectIssueSelfStudy() {
            this.$router.push({
                path: this.$bwPortalView + this.$bwTrainingsView + '/issue-self-study'
            });
        }
    }
}
</script>
