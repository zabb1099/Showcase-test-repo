<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">Account</h2>
                    </div>
                    <div class="card-container">
                        <div @click="selectUsers" class="orange-tile mt-5">
                            <h4 class="card-title">Users</h4>
                        </div>
                        <div @click="selectUsersAdmin" class="green-tile">
                            <h4 class="card-title">Users Admin</h4>
                        </div>
                        <div @click="selectUserGroups" class="teal-tile">
                            <h4 class="card-title">User Groups</h4>
                        </div>
                        <div @click="selectNewUserForm" class="purple-tile">
                            <h4 class="card-title">New User Form</h4>
                        </div>
                        <div @click="selectQuestTemplates" class="orange-tile">
                            <h4 class="card-title">Quest. Templates</h4>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
import Users from "./Users";
import UsersAdmin from "./UsersAdmin";
import UserGroups from "./UserGroups";
import NewUserForm from "./NewUserForm";
import QuestTemplates from "./QuestTemplates";

export default {
    name: "AccountHome",
    components: {
        Users,
        UsersAdmin,
        UserGroups,
        NewUserForm,
        QuestTemplates
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        selectUsers() {
            this.$router.push({
                path: this.$bwPortalView + this.$accountView + '/users'
            });
        },
        selectUsersAdmin() {
            this.$router.push({
                path: this.$bwPortalView + this.$accountView + '/users-admin'
            });
        },
        selectUserGroups() {
            this.$router.push({
                path: this.$bwPortalView + this.$accountView + '/user-groups'
            });
        },
        selectNewUserForm() {
            this.$router.push({
                path: this.$bwPortalView + this.$accountView + '/new-user-form'
            });
        },
        selectQuestTemplates() {
            this.$router.push({
                path: this.$bwPortalView + this.$accountView + '/quest-templates'
            });
        }
    }
}
</script>
