<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">Management</h2>
                    </div>
                    <div class="card-container">
                        <div @click="selectUsers" class="orange-tile mt-5">
                            <h4 class="card-title">Users</h4>
                        </div>
                        <div @click="selectUserAudits" class="green-tile">
                            <h4 class="card-title">User Audits</h4>
                        </div>
                        <div @click="selectReAssignTasks" class="teal-tile">
                            <h4 class="card-title">Re-Assign Tasks</h4>
                        </div>
                        <div @click="selectTeamHolidays" class="purple-tile">
                            <h4 class="card-title">Team Holidays</h4>
                        </div>
                        <div @click="selectHRHolidays" class="orange-tile">
                            <h4 class="card-title">HR Holidays</h4>
                        </div>
                        <div @click="selectStarterForm" class="green-tile">
                            <h4 class="card-title">Starter Form</h4>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
import Users from "./Users";
import UserAudits from "./UserAudits";
import ReAssignTasks from "./ReAssignTasks";
import TeamHolidays from "./TeamHolidays";
import HRHolidays from "./HRHolidays";
import StarterForm from "./StarterForm";

export default {
    name: "ManagementHome",
    components: {
        Users,
        UserAudits,
        ReAssignTasks,
        TeamHolidays,
        HRHolidays,
        StarterForm
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        selectUsers() {
            this.$router.push({
                path: this.$bwPortalView + this.$managementView + '/users'
            });
        },
        selectUserAudits() {
            this.$router.push({
                path: this.$bwPortalView + this.$managementView + '/user-audits'
            });
        },
        selectReAssignTasks() {
            this.$router.push({
                path: this.$bwPortalView + this.$managementView + '/re-assign-tasks'
            });
        },
        selectTeamHolidays() {
            this.$router.push({
                path: this.$bwPortalView + this.$managementView + '/team-holidays'
            });
        },
        selectHRHolidays() {
            this.$router.push({
                path: this.$bwPortalView + this.$managementView + '/hr-holidays'
            });
        },
        selectStarterForm() {
            this.$router.push({
                path: this.$bwPortalView + this.$managementView + '/starter-form'
            });
        },
    }
}
</script>
