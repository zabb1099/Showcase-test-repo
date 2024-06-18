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
                            :class="{disabled: !$v.clientId.required}"
                            :disabled="!$v.clientId.required">
                        {{ isSearching ? "Searching..." : "Search" }}
                    </button>
                </div>
            </div>
            <form class="form-flex" @submit.prevent>
                <div v-if="noData">
                    <div class="main card shadow">
                        <h2 class="pt-3 pb-2 main-header">Lock not found!</h2>
                    </div>
                </div>
                <div v-if="clientData.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex3">Client ID</div>
                        <div class="items-header flex3">Date Locked</div>
                        <div class="items-header flex3">Locked By</div>
                        <div class="items-header flex3"></div>
                    </div>
                    <div v-for="data in clientData" :key="data.ACC_ID" class="shadow main-table">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex3 first-column">{{ data.Client_ID }}</div>
                            <div class="items-opened flex3">
                                {{
                                    moment(data.Date_Created).format("MMM Do YYYY")
                                }}
                            </div>
                            <div class="items-opened flex3">{{ data.UserFullName }}</div>
                            <div class="items-opened flex3 pl-3">
                                <button @click="toggleShowAuditModal" type="button" class="green-btn">
                                    Unlock
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
import {required} from "vuelidate/lib/validators";
import moment from "moment";
import AuditReasonModal from "../AuditReasonModal";

export default {
    name: "ClientFileLockedFSS",
    components: {
        AuditReasonModal
    },
    props: {
        successMessage: Function,
        errorMessage: Function
    },
    data() {
        return {
            moment: moment,
            clientData: [],
            selectedFile: '',
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
                .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$unlockClientFileView + vm.$fssView, {
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

                    if (!vm.noData) {
                        vm.selectedFile = vm.clientData[0].ACC_ID;
                    }

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
        unlockClientFile() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            let data = {
                id: vm.selectedFile,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$unlockClientFileView + vm.$fssView, data, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.successMessage();
                    vm.selectedFile = '';
                    vm.reason = '';
                    vm.clientData = [];
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
            this.unlockClientFile();
        }
    }
}
</script>
