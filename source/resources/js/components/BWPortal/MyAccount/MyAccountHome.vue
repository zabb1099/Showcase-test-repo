<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">My Account</h2>
                    </div>
                    <div class="card-container">
                        <div @click="selectPersonalInformation" class="orange-tile mt-5">
                            <h4 class="card-title">Personal Information</h4>
                        </div>
                        <div @click="selectCV" class="green-tile">
                            <h4 class="card-title">CV</h4>
                        </div>
                        <div @click="selectMyDocuments" class="teal-tile">
                            <h4 class="card-title">My Documents</h4>
                        </div>
                        <div @click="selectHolidayRequests" class="purple-tile">
                            <h4 class="card-title">Holiday Requests</h4>
                        </div>
                        <div @click="selectTeamCalendar" class="orange-tile">
                            <h4 class="card-title">Team Calendar</h4>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
import PersonalInformation from "./PersonalInformation";
import CV from "./CV";
import MyDocuments from "./MyDocuments";
import HolidayRequests from "./HolidayRequests";
import TeamCalendar from "./TeamCalendar";

export default {
    name: "MyAccountHome",
    components: {
      PersonalInformation,
      CV,
      MyDocuments,
      HolidayRequests,
      TeamCalendar
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        selectPersonalInformation() {
            this.$router.push({
                path: this.$bwPortalView + this.$myAccountView + '/personal-information'
            });
        },
        selectCV() {
            this.$router.push({
                path: this.$bwPortalView + this.$myAccountView + '/cv'
            });
        },
        selectMyDocuments() {
            this.$router.push({
                path: this.$bwPortalView + this.$myAccountView + '/my-documents'
            });
        },
        selectHolidayRequests() {
            this.$router.push({
                path: this.$bwPortalView + this.$myAccountView + '/holiday-requests'
            });
        },
        selectTeamCalendar() {
            this.$router.push({
                path: this.$bwPortalView + this.$myAccountView + '/team-calendar'
            });
        }
    }
}
</script>
