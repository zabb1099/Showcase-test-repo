<template>
    <fieldset :disabled="loading" class="loadingSpinner pageSize">
        <div class="loader" v-if="loading"></div>

        <AuditReasonModal
            :doShow="doShowAuditModal" @close="toggleShowAuditModal" @submitAuditReason="getAuditReason">
        </AuditReasonModal>

        <div class="mt-3">
            <div class="card shadow py-3 mb-3">
                <div class="form-flex-item-job no-border-bottom">
                    <label class="form-label">Client ID</label>
                    <input class="form-field-job" type="number" v-model.trim="$v.clientId.$model">
                    <button @click="getClientHistory()"
                            class="search-btn blue-btn"
                            :class="{disabled: !$v.clientId.required}"
                            :disabled="!$v.clientId.required">
                        {{ isSearching ? "Searching..." : "Search" }}
                    </button>
                </div>
            </div>
            <form class="form-flex" @submit.prevent>
                <div v-if="noData">
                    <div class="main card shadow">
                        <h2 class="pt-3 pb-2 main-header">Client not found!</h2>
                    </div>
                </div>
                <div v-if="clientHistory.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex3">ID</div>
                        <div class="items-header flex3">Date/Time</div>
                        <div class="items-header flex3">Advisor Name</div>
                        <div class="items-header flex3">Description</div>
                        <div class="items-header flex1">Delete</div>
                    </div>
                    <div v-for="data in clientHistory" :key="data.id" class="shadow main-table">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex3 first-column">{{ data.id }}</div>
                            <div class="items-opened flex3">
                                {{ moment(data.dateTime).format("MMM Do YYYY, HH:mm:ss") }}
                            </div>
                            <div class="items-opened flex3">
                                <div v-if="data.statusType === '2'">{{ data.username }}</div>
                                <select v-else class="form-field" v-model="data.userId"
                                        @change="addHistoryUser(data.statusId, data.userId)">
                                    <option v-if="!advisorExists(data.userId, data.teamId)" :value="data.userId"
                                            disabled>
                                        {{ data.username }}
                                    </option>
                                    <option v-for="(user, index) in users[data.teamId]" :key="index"
                                            :value="user.userId">
                                        {{ user.username }}
                                    </option>
                                </select>
                            </div>
                            <div class="items-opened flex3">
                                <select v-if="data.statusType === '2'" class="form-field" v-model="data.userId"
                                        @change="addAssignedUser(data.statusId, data.userId)">
                                    <option v-if="!advisorExists(data.userId, data.teamId)" :value="data.userId"
                                            disabled>
                                        {{ assignedTo }} {{ data.statusDescription }}
                                    </option>
                                    <option v-for="(user, index) in users[data.teamId]" :key="index"
                                            :value="user.userId">
                                        {{ assignedTo }} {{ user.username }}
                                    </option>
                                </select>
                                <div v-else>{{ data.statusDescription }}</div>
                            </div>
                            <div class="items-opened flex1 pl-3">
                                <input v-if="data.statusType === '1'" type="checkbox" :value="data.statusId"
                                       v-model="checkedStatusesHistory">
                                <input v-if="data.statusType === '2'" type="checkbox" :value="data.statusId"
                                       v-model="checkedStatusesAssigned">
                                <input v-if="data.statusType === '3'" type="checkbox" :value="data.statusId"
                                       v-model="checkedStatusesVerified">
                            </div>
                        </div>
                    </div>
                    <div class="card shadow py-3 mb-3">
                        <button @click="toggleShowAuditModal" class="clearfix green-btn float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
</template>

<script>
import {required} from "vuelidate/lib/validators";
import moment from "moment";
import AuditReasonModal from "../AuditReasonModal";

export default {
    name: "LeadDispositions",
    components: {
        AuditReasonModal
    },
    props: {
        errorMessage: Function
    },
    data() {
        return {
            moment: moment,
            users: {},
            clientHistory: [],
            checkedStatusesHistory: [],
            checkedStatusesAssigned: [],
            checkedStatusesVerified: [],
            historyUsers: [],
            assignedUsers: [],
            clientId: '',
            reason: '',
            assignedTo: 'Assigned to ',
            isSearching: false,
            noData: false,
            loading: false,
            updating: false,
            doShowAuditModal: false
        }
    },
    validations: {
        clientId: {
            required
        }
    },
    methods: {
        addHistoryUser(id, userId) {
            this.historyUsers.push({
                id: id,
                userId: userId
            });
        },
        addAssignedUser(id, userId) {
            this.assignedUsers.push({
                id: id,
                userId: userId
            });
        },
        getClientHistory() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;

            if (!vm.updating) {
                vm.isSearching = true;
            }

            axios
                .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadDisposition + vm.$historyDisposition, {
                    params: {
                        client_id: vm.clientId
                    },
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.users = response.data.users;
                    vm.clientHistory = response.data.clientHistory;
                    !vm.clientHistory.length ? vm.noData = true : vm.noData = false;

                    vm.isSearching = false;
                    vm.loading = false;

                    if (vm.updating) {
                        vm.successMessage();
                        vm.reason = '';
                    }
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.updating = false;
                });
        },
        removeHistoryStatuses() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            let data = {
                id: vm.checkedStatusesHistory,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadDisposition + vm.$historyDisposition, data, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.checkedStatusesHistory = [];
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.checkRequestsHaveFinished();
                });
        },
        updateHistoryUser() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            let data = {
                historyUsers: vm.historyUsers,
                reason: vm.reason
            };

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadDisposition + vm.$historyAssigned, data, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.historyUsers = [];
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.checkRequestsHaveFinished();
                });
        },
        deleteAssignedStatuses() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            axios
                .delete(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadDisposition + vm.$assignedDisposition, {
                    data: {
                        id: vm.checkedStatusesAssigned,
                        reason: vm.reason
                    },
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.checkedStatusesAssigned = [];
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.checkRequestsHaveFinished();
                });
        },
        updateAssignedUser() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            let data = {
                assignedUsers: vm.assignedUsers,
                reason: vm.reason
            };

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadDisposition + vm.$updateAssigned, data, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.assignedUsers = [];
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.checkRequestsHaveFinished();
                });
        },
        removeVerifiedStatuses() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            let data = {
                id: vm.checkedStatusesVerified,
                reason: vm.reason,
                client_id: vm.clientId
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadDisposition + vm.$historyVerified, data, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.checkedStatusesVerified = [];
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.checkRequestsHaveFinished();
                });
        },
        toggleShowAuditModal() {
            this.doShowAuditModal = !this.doShowAuditModal;
        },
        getAuditReason(reason) {
            this.reason = reason;
            this.toggleShowAuditModal();

            if (this.checkedStatusesHistory.length > 0) this.removeHistoryStatuses();
            if (this.historyUsers.length > 0) this.updateHistoryUser();
            if (this.checkedStatusesAssigned.length > 0) this.deleteAssignedStatuses();
            if (this.assignedUsers.length > 0) this.updateAssignedUser();
            if (this.checkedStatusesVerified.length > 0) this.removeVerifiedStatuses();
        },
        checkRequestsHaveFinished() {
            if (this.checkedStatusesHistory.length <= 0 &&
                this.historyUsers.length <= 0 &&
                this.checkedStatusesAssigned.length <= 0 &&
                this.assignedUsers.length <= 0 &&
                this.checkedStatusesVerified <= 0
            ) this.getClientHistory();
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'Client History Updated!'
            });
        },
        advisorExists(advisorId, teamId) {
            let advisorFound = false;

            this.users[teamId].forEach(function (user) {
                if (user.userId == advisorId) advisorFound = true;
            })

            return advisorFound;
        }
    }
}
</script>
