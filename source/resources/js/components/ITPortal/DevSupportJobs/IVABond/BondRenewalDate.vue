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
                    <button @click="getBondRenewalDate()"
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
                <div v-if="clientData.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex4">Client ID</div>
                        <div class="items-header flex4">Bond Renewal Date</div>
                        <div class="items-header flex4"></div>
                    </div>
                    <div v-for="data in clientData" :key="data.ID" class="shadow main-table">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex4 first-column">{{ data.ClientID }}</div>
                            <div class="items-opened flex4">
                                <input class="form-field-job" placeholder="YYYY-MM-DD" v-model.trim="$v.date.$model">
                            </div>
                            <div class="items-opened flex4 pl-3">
                                <button @click="toggleShowAuditModal" class="green-btn"
                                        :class="{'disabled' : !$v.date.dateFormat}" :disabled="!$v.date.dateFormat">
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

import moment from "moment";
import AuditReasonModal from "../AuditReasonModal";
import {helpers, required} from "vuelidate/lib/validators";

const dateFormat = helpers.regex('dateFormat', /[0-9]{4}[\-][0-9]{2}[\-][0-9]{2}$/);

export default {
    name: "BondRenewalDate",
    components: {
        AuditReasonModal
    },
    data() {
        return {
            moment: moment,
            clientData: [],
            clientId: '',
            date: '',
            id: '',
            reason: '',
            isSearching: false,
            noData: false,
            loading: false,
            doShowAuditModal: false
        }
    },
    validations: {
        clientId: {
            required
        },
        date: {
            dateFormat
        }
    },
    methods: {
        getBondRenewalDate() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.isSearching = true;

            axios
                .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$ivaBondView + vm.$bondRenewalDate, {
                    params: {
                        client_id: vm.clientId
                    },
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.clientData = response.data;

                    if (vm.clientData[0]) {
                        vm.date = moment(vm.clientData[0].date).format('YYYY-MM-DD');
                        vm.id = vm.clientData[0].ID;
                    }

                    !vm.clientData.length ? vm.noData = true : vm.noData = false;
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.isSearching = false;
                    vm.loading = false;
                });
        },
        updateBondRenewalDate() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;

            let data = {
                id: vm.id,
                date: vm.date,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$ivaBondView + vm.$bondRenewalDate, data, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.successMessage();
                    vm.clientId = '';
                    vm.reason = '';
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.clientData = [];
                    vm.loading = false;
                });
        },
        toggleShowAuditModal() {
            this.doShowAuditModal = !this.doShowAuditModal;
        },
        getAuditReason(reason) {
            this.reason = reason;
            this.toggleShowAuditModal();
            this.updateBondRenewalDate();
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'Bond Renewal Date Updated!'
            });
        },
        errorMessage() {
            this.$swal({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 5000,
                icon: 'error',
                title: 'Error!'
            });
        }
    }
}
</script>
