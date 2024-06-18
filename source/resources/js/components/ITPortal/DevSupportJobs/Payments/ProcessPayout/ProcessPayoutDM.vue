<template>
    <fieldset :disabled="loading" class="loadingSpinner">
        <div class="loader" v-if="loading"/>
        <AuditReasonModal :doShow="doShowAuditModal" @close="toggleShowAuditModal" @submitAuditReason="getAuditReason"/>

        <div class="mt-3">
            <form class="form-flex" @submit.prevent>
                <div v-if="payouts !== null && payouts.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex1">ID</div>
                        <div class="items-header flex1">Status</div>
                        <div class="items-header flex2">Date Finished</div>
                        <div class="items-header flex1">Records Affected</div>
                        <div class="items-header flex5">Notes</div>
                        <div class="items-header flex2"/>
                    </div>
                    <div class="shadow main-table" v-for="payout in payouts" :key="payout.ID">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex1 first-column">{{ payout.ID }}</div>
                            <div class="items-opened flex1">{{ payout.Status }}</div>
                            <div class="items-opened flex2">
                                {{
                                    moment(payout.DateFinished).format("MMM Do YYYY")
                                }}
                            </div>
                            <div class="items-opened flex1">{{ payout.RecordsAffected }}</div>
                            <div class="items-opened flex5">{{ payout.Notes }}</div>
                            <div class="items-opened flex2 pl-3">
                                <button @click="toggleShowAuditModal(payout)" type="button" class="green-btn">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="payouts !== null && !payouts.length" class="main card shadow">
                    <h2 class="pt-3 pb-2 main-header">There are no payouts to process for DM Debtsolv!</h2>
                </div>
            </form>
        </div>
    </fieldset>
</template>

<script>
    import moment from "moment";
    import AuditReasonModal from "../../AuditReasonModal";

    export default {
        name: "ProcessPayoutDM",
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
                payouts: null,
                selectedPayout: {},
                reason: '',
                loading: false,
                updating: false,
                doShowAuditModal: false
            }
        },
        methods: {
            getPayouts() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.loading = true;

                axios
                    .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$processPayoutView + vm.$debtsolvDmView, {
                        headers: {"Authorization": `Bearer ${bearerToken}`}
                    })
                    .then(response => {
                        vm.payouts = response.data;
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
            processPayout() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.loading = true;
                vm.updating = true;

                const payoutData = {
                    id: vm.selectedPayout.ID,
                    reason: vm.reason
                }

                axios
                    .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$processPayoutView + vm.$debtsolvDmView, payoutData, {
                        headers: {"Authorization": `Bearer ${bearerToken}`}
                    })
                    .then(response => {
                        vm.reason = '';
                    })
                    .catch(error => {
                        vm.errorMessage();
                    })
                    .finally(() => {
                        vm.getPayouts();
                    });
            },
            toggleShowAuditModal(payout) {
                this.doShowAuditModal = !this.doShowAuditModal;
                if (this.doShowAuditModal) this.selectedPayout = payout;
            },
            getAuditReason(reason) {
                this.reason = reason;
                this.toggleShowAuditModal();
                this.processPayout();
            }
        },
        mounted() {
            this.getPayouts();
        }
    }
</script>
