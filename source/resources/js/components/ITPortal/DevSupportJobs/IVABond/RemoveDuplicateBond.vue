<template>
    <fieldset :disabled="loading" class="loadingSpinner pageSize">
        <div class="loader" v-if="loading"></div>

        <AuditReasonModal
            :doShow="doShowAuditModal" @close="toggleShowAuditModal" @submitAuditReason="getAuditReason">
        </AuditReasonModal>

        <div class="mt-3">
            <div class="card shadow py-3">
                <form class="form-flex" @submit.prevent>
                    <div class="form-flex-item-job no-border-bottom">
                        <label class="form-label">Client ID</label>
                        <input class="form-field-job" type="number" v-model.trim="$v.clientId.$model">
                        <button @click="toggleShowAuditModal" type="button" class="green-btn"
                                :class="{disabled: $v.$invalid}" :disabled="$v.$invalid">
                            Remove Bond
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
</template>

<script>
import {required} from 'vuelidate/lib/validators';
import AuditReasonModal from "../AuditReasonModal";

export default {
    name: "RemoveDuplicateBond",
    components: {
        AuditReasonModal
    },
    data() {
        return {
            clientId: '',
            reason: '',
            isBondRemoved: false,
            loading: false,
            doShowAuditModal: false,
            errorMessage: ''
        }
    },
    validations: {
        clientId: {
            required
        }
    },
    methods: {
        removeDuplicateBond() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;

            const clientId = {
                client_id: vm.clientId,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$ivaBondView + vm.$removeDuplicateBond, clientId, {
                    headers: { "Authorization": `Bearer ${bearerToken}` }
                })
                .then(response => {
                    vm.$swal.fire({
                        icon: 'success',
                        title: 'Duplicate Bond Removed!'
                    });

                    vm.clientId = '';
                    vm.reason = '';
                })
                .catch(error => {
                    error.response.data == 'There are no duplicate bonds to remove.' ? vm.errorMessage = error.response.data : vm.errorMessage = 'Error!';

                    vm.$swal.fire({
                        icon: 'error',
                        title: vm.errorMessage
                    });
                })
                .finally(() => {
                    vm.loading = false;
                });
        },
        toggleShowAuditModal() {
            this.doShowAuditModal = !this.doShowAuditModal;
        },
        getAuditReason(reason) {
            this.reason = reason;
            this.toggleShowAuditModal();
            this.removeDuplicateBond();
        }
    }
}
</script>
