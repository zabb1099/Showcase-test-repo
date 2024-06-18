<template>
    <fieldset :disabled="loading" class="loadingSpinner">
        <div class="loader" v-if="loading"/>
        <AuditReasonModal :doShow="doShowAuditModal" @close="toggleShowAuditModal" @submitAuditReason="getAuditReason"/>

        <div class="mt-3">
            <form class="form-flex" @submit.prevent>
                <div v-if="payments !== null && payments.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex1">ID</div>
                        <div class="items-header flex1">Status</div>
                        <div class="items-header flex2">Date Finished</div>
                        <div class="items-header flex1">Records Affected</div>
                        <div class="items-header flex5">Notes</div>
                        <div class="items-header flex2"/>
                    </div>
                    <div class="shadow main-table" v-for="payment in payments" :key="payment.ID">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex1 first-column">{{ payment.ID }}</div>
                            <div class="items-opened flex1">{{ payment.Status }}</div>
                            <div class="items-opened flex2">
                                {{
                                    moment(payment.DateFinished).format("MMM Do YYYY")
                                }}
                            </div>
                            <div class="items-opened flex1">{{ payment.RecordsAffected }}</div>
                            <div class="items-opened flex5">{{ payment.Notes }}</div>
                            <div class="items-opened flex2 pl-3">
                                <button @click="toggleShowAuditModal(payment)" type="button" class="green-btn">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="payments !== null && !payments.length" class="main card shadow">
                    <h2 class="pt-3 pb-2 main-header">There are no card payment errors to fix for DM Debtsolv!</h2>
                </div>
            </form>
        </div>
    </fieldset>
</template>

<script>
    import moment from "moment";
    import AuditReasonModal from "../../AuditReasonModal";

    export default {
        name: "CardPaymentDM",
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
                payments: null,
                selectedPayment: {},
                reason: '',
                loading: false,
                updating: false,
                doShowAuditModal: false
            }
        },
        methods: {
            getPayments() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.loading = true;

                axios
                    .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$cardPayment + vm.$debtsolvDmView, {
                        headers: {"Authorization": `Bearer ${bearerToken}`}
                    })
                    .then(response => {
                        vm.payments = response.data;
                        vm.loading = false;
                        if (vm.updating) vm.successMessage();
                    })
                    .catch(error => {
                        vm.errorMessage();
                    })
                    .finally(() => {
                        vm.updating = false;
                    });
            },
            processPayment() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.loading = true;
                vm.updating = true;

                const paymentData = {
                    id: vm.selectedPayment.ID,
                    reason: vm.reason
                }

                axios
                    .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$cardPayment + vm.$debtsolvDmView, paymentData, {
                        headers: {"Authorization": `Bearer ${bearerToken}`}
                    })
                    .then(response => {
                        vm.reason = '';
                    })
                    .catch(error => {
                        vm.errorMessage();
                    })
                    .finally(() => {
                        vm.getPayments();
                    });
            },
            toggleShowAuditModal(payment) {
                this.doShowAuditModal = !this.doShowAuditModal;
                if (this.doShowAuditModal) this.selectedPayment = payment;
            },
            getAuditReason(reason) {
                this.reason = reason;
                this.toggleShowAuditModal();
                this.processPayment();
            }
        },
        mounted() {
            this.getPayments();
        }
    }
</script>
