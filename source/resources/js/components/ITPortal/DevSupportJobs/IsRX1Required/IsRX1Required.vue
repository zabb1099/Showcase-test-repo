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
                    <button @click="getIsRX1Required()"
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
                        <div class="items-header flex2">RX1/Sale of Property</div>
                        <div class="items-header flex2">Is Property Housing Association?</div>
                        <div class="items-header flex2"></div>
                    </div>
                    <div class="shadow main-table">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex1">{{ clientId }}</div>
                            <div class="items-opened flex2">
                                <select class="form-field" v-model="isRX1Required">
                                    <option :value="0">RX1</option>
                                    <option :value="1">Sale of Property</option>
                                </select>
                            </div>
                            <div class="items-opened flex2">
                                <select class="form-field" v-model="isPropertyHA">
                                    <option :value="0">No</option>
                                    <option :value="1">Yes</option>
                                </select>
                            </div>
                            <div class="items-opened flex2 pl-3">
                                <button @click="toggleShowAuditModal()" type="button" class="green-btn">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="isPropertyHA === 1 && isRX1Required === 0">
                    <div class="main card shadow">
                        <h6 class="notes">Note: As the client has a housing association property listed on their file, the Sale of Property letter will generate and override the RX1 selection.</h6>
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
    name: "IsRX1Required",
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
            isRX1Required: 0,
            isPropertyHA: 0,
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
        getIsRX1Required() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;

            if (!vm.updating) {
                vm.isSearching = true;
            }

            axios
                .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$isRX1Required, {
                    params: {
                        client_id: vm.clientId
                    },
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.clientData = response.data;
                    vm.isRX1Required = parseInt(vm.clientData[0].RX1_not_required);
                    vm.isPropertyHA = parseInt(vm.clientData[0].Is_property_HA);

                    vm.clientData.length ? vm.noData = false : vm.noData = true;
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
        updateIsRX1Required() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.updating = true;

            const clientData = {
                client_id: vm.clientId,
                RX1_not_required: vm.isRX1Required,
                Is_property_HA: vm.isPropertyHA,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$isRX1Required, clientData, {
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
                    vm.getIsRX1Required();
                });
        },
        toggleShowAuditModal() {
            this.doShowAuditModal = !this.doShowAuditModal;
        },
        getAuditReason(reason) {
            this.reason = reason;
            this.toggleShowAuditModal();
            this.updateIsRX1Required();
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'Client has been updated!'
            });
        }
    }
}
</script>
