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
                    <button @click="getClientFile()"
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
                        <div class="items-header flex1">Client ID</div>
                        <div class="items-header flex1">Lead Source</div>
                        <div class="items-header flex2"></div>
                    </div>
                    <div v-for="data in clientData" :key="data.MarketingDataID" class="shadow main-table">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex1 first-column">{{
                                    data.MarketingDataClientID
                                }}
                            </div>
                            <div class="items-opened flex1">{{ data.TypeLeadSourceDescription }}</div>
                            <div class="items-opened flex2 pl-3">
                                <button @click="toggleShowAuditModal" type="button" class="green-btn">
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
    name: "LeadsTestCase",
    components: {
        AuditReasonModal
    },
    props: {
        errorMessage: Function
    },
    data() {
        return {
            clientData: [],
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
        getClientFile() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;

            if (!vm.updating) {
                vm.isSearching = true;
            }

            axios
                .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$testCaseFileView + vm.$leadsView, {
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
        updateClientFile() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            const clientId = {
                client_id: vm.clientId,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$testCaseFileView + vm.$leadsView, clientId, {
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
                    vm.getClientFile();
                });
        },
        toggleShowAuditModal() {
            this.doShowAuditModal = !this.doShowAuditModal;
        },
        getAuditReason(reason) {
            this.reason = reason;
            this.toggleShowAuditModal();
            this.updateClientFile();
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'File updated to a test case!'
            });
        }
    }
}
</script>
