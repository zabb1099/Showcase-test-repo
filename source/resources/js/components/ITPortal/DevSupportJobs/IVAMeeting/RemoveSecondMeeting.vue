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
                    <button @click="getSecondMeeting()"
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
                <div v-if="clientData.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex1">ID</div>
                        <div class="items-header flex1">Client ID</div>
                        <div class="items-header flex2">Description</div>
                        <div class="items-header flex2">Meeting No.</div>
                        <div class="items-header flex2"></div>
                    </div>
                    <div class="shadow main-table" v-for="(data, key) in clientData" :key="data.ID">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex1 first-column">{{ data.ID }}</div>
                            <div class="items-opened flex1">{{ data.ClientID }}</div>
                            <div class="items-opened flex2">{{ data.Description }}</div>
                            <div v-if="key === 0" class="items-opened flex2">P</div>
                            <div v-else class="items-opened flex2">{{ key }}</div>
                            <div class="items-opened flex2 pl-3">
                                <button @click="toggleShowAuditModal(data)" type="button"
                                        :class="[ allMeetingIdsExceptLast.includes(data.ID)
                                                  || data.Description.includes('First IVA Meeting')
                                                   ? 'grey-btn' : 'green-btn' ]">
                                    <span v-if="removingSingleMeeting.indexOf(data.ID) !== -1">Removing...</span>
                                    <span v-else-if="!allMeetingIdsExceptLast.includes(data.ID)
                                                      && removingSingleMeeting.indexOf(data.ID) === -1
                                                      && data.Description.includes('Initial Proposed Meeting')">
                                        Recommended
                                    </span>
                                    <span v-else>Remove</span>
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
    name: "RemoveSecondMeeting",
    components: {
        AuditReasonModal
    },
    props: {
        errorMessage: Function
    },
    data() {
        return {
            selectedMeeting: {},
            clientData: [],
            removingSingleMeeting: [],
            allMeetingIdsExceptLast: [],
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
        getSecondMeeting() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;

            if (!vm.updating) {
                vm.isSearching = true;
            }

            axios
                .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$ivaMeetingView + vm.$removeSecondMeeting, {
                    params: {
                        client_id: vm.clientId
                    },
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.clientData = response.data;
                    !vm.clientData.length ? vm.noData = true : vm.noData = false;
                    vm.allMeetingIdsExceptLast = vm.clientData.map(({ID}) => String(ID)).slice(0, -1);
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
        removeSecondMeeting() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            const clientData = {
                id: vm.selectedMeeting.ID,
                client_id: vm.clientId,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$ivaMeetingView + vm.$removeSecondMeeting, clientData, {
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
                    vm.getSecondMeeting();
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
            this.removeSecondMeeting();
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'Meeting Removed!'
            });
        }
    }
}
</script>
