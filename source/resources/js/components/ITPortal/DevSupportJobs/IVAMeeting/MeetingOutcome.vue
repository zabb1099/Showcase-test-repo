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
                    <button @click="getMeetingOutcome()"
                            class="search-btn blue-btn"
                            :class="{disabled: $v.$invalid}"
                            :disabled="$v.$invalid">
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
                <div v-if="meetingOutcome.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex1">ID</div>
                        <div class="items-header flex1">Client ID</div>
                        <div class="items-header flex2">Description</div>
                        <div class="items-header flex2">Meeting Decision</div>
                        <div class="items-header flex2"></div>
                    </div>
                    <div class="shadow main-table" v-for="data in meetingOutcome" :key="data.id">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex1 first-column">{{ data.id }}</div>
                            <div class="items-opened flex1">{{ data.client_id }}</div>
                            <div class="items-opened flex2">{{ data.description }}</div>
                            <div class="items-opened flex2">
                                <select class="form-field" v-model="data.meeting_decision.ID">
                                    <option v-for="type in meetingOutcomeType" :value="type.id">
                                        {{ type.description }}
                                    </option>
                                </select>
                            </div>
                            <div class="items-opened flex2 pl-3">
                                <button @click="toggleShowAuditModal(data)" type="button" class="green-btn">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
</template>

<script>
import {required} from 'vuelidate/lib/validators';
import AuditReasonModal from "../AuditReasonModal";

export default {
    name: "MeetingOutcome",
    components: {
        AuditReasonModal
    },
    props: {
        errorMessage: Function
    },
    data() {
        return {
            clientData: {},
            selectedMeeting: {},
            meetingOutcome: [],
            meetingOutcomeType: [],
            clientId: '',
            reason: '',
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
        getMeetingOutcome() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;

            if (!vm.updating) {
                vm.isSearching = true;
            }

            axios
                .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$ivaMeetingView + vm.$meetingOutcome, {
                    params: {
                        client_id: vm.clientId
                    },
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.clientData = response.data;
                    vm.meetingOutcome = vm.clientData.meetingOutcome;
                    vm.meetingOutcomeType = vm.clientData.meetingOutcomeType;
                    vm.meetingOutcome.length ? vm.noData = false : vm.noData = true;
                    vm.isSearching = false;
                    vm.loading = false;

                    if (vm.updating) {
                        vm.successMessage();
                    }
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.updating = false;
                });
        },
        updateMeetingOutcome() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            const clientData = {
                id: vm.selectedMeeting.id,
                client_id: vm.clientId,
                meeting_outcome: vm.selectedMeeting.meeting_decision.ID,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$ivaMeetingView + vm.$meetingOutcome, clientData, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.reason = '';
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.getMeetingOutcome();
                });
        },
        toggleShowAuditModal(meeting) {
            this.doShowAuditModal = !this.doShowAuditModal;

            if (this.doShowAuditModal) {
                this.selectedMeeting = meeting;
            }
        },
        getAuditReason(reason) {
            this.reason = reason;
            this.toggleShowAuditModal();
            this.updateMeetingOutcome();
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'Meeting Updated!'
            });
        }
    }
}
</script>
