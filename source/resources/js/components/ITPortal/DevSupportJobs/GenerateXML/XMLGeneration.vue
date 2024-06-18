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
                                :class="{disabled: !$v.clientId.required}"
                                :disabled="!$v.clientId.required">
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
import AuditReasonModal from "../AuditReasonModal";

export default {
    name: "XMLGeneration",
    components: {
        AuditReasonModal
    },
    props: {
        successMessage: Function,
        errorMessage: Function
    },
    data() {
        return {
            clientId: '',
            reason: '',
            isGenerating: false,
            loading: false,
            doShowAuditModal: false
        }
    },
    validations: {
        clientId: {
            required
        }
    },
    methods: {
        generateXML() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;
            vm.isGenerating = true;

            const clientId = {
                client_id: vm.clientId,
                reason: vm.reason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$xmlGeneration + vm.$debtsolvIvaView, clientId, {
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
                    vm.isGenerating = false;
                    vm.loading = false;
                });
        },
        toggleShowAuditModal() {
            this.doShowAuditModal = !this.doShowAuditModal;
        },
        getAuditReason(reason) {
            this.reason = reason;
            this.toggleShowAuditModal();
            this.generateXML();
        }
    }
}
</script>
