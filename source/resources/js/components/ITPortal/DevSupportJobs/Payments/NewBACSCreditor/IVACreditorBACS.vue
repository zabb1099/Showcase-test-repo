<template>
    <fieldset :disabled="loading" class="loadingSpinner">
        <div class="loader" v-if="loading"/>
        <AuditReasonModal :doShow="doShowAuditModal" @close="toggleShowAuditModal" @submitAuditReason="getAuditReason"/>

        <div class="mt-3">
            <div class="card shadow py-3">
                <form class="form-flex" @submit.prevent>
                    <div class="form-flex-item-job no-border-bottom">
                        <label class="form-label">Creditor ID</label>
                        <input class="form-field-job" type="number" v-model.trim="$v.creditorId.$model">
                        <button @click="toggleShowAuditModal" type="button" class="green-btn"
                                :class="{disabled: !$v.creditorId.required}"
                                :disabled="!$v.creditorId.required">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
</template>

<script>
    import {required} from 'vuelidate/lib/validators';
    import AuditReasonModal from "../../AuditReasonModal";

    export default {
        name: "IVACreditorBACS",
        components: {
            AuditReasonModal
        },
        props: {
            successMessage: Function,
            errorMessage: Function
        },
        data() {
            return {
                creditorId: '',
                reason: '',
                isUpdating: false,
                loading: false,
                doShowAuditModal: false
            }
        },
        validations: {
            creditorId: {
                required
            }
        },
        methods: {
            addNewBACSCreditor() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.loading = true;
                vm.isUpdating = true;

                const creditorId = {
                    creditor_id: vm.creditorId,
                    reason: vm.reason
                }

                axios
                    .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$newBACSCreditorView + vm.$debtsolvIvaView, creditorId, {
                        headers: {"Authorization": `Bearer ${bearerToken}`}
                    })
                    .then(response => {
                        vm.successMessage();
                        vm.creditorId = '';
                        vm.reason = '';
                    })
                    .catch(error => {
                        vm.errorMessage();
                    })
                    .finally(() => {
                        vm.isUpdating = false;
                        vm.loading = false;
                    });
            },
            toggleShowAuditModal() {
                this.doShowAuditModal = !this.doShowAuditModal;
            },
            getAuditReason(reason) {
                this.reason = reason;
                this.toggleShowAuditModal();
                this.addNewBACSCreditor();
            }
        }
    }
</script>
