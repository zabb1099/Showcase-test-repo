<template>
    <fieldset :disabled="loading" class="loadingSpinner">
        <div class="loader" v-if="loading" />
        <AuditReasonModal :doShow="doShowAuditModal" @close="toggleShowAuditModal" @submitAuditReason="getAuditReason" />

        <div class="mt-3">
            <div class="card shadow py-3 pl-3 mb-3">
                <div class="form-flex-item-job no-border-bottom">
                    <input placeholder="Client ID to Keep" class="form-field-job" type="number" @keydown="checkNumeric($event)" v-model.number.trim="$v.clientIdToKeep.$model">
                </div>
                <div class="form-flex-item-job no-border-bottom pt-3">
                    <input placeholder="Client ID to Delete" class="form-field-job" type="number" @keydown="checkNumeric($event)" v-model.number="clientIdToRemove">
                    <img id="plus-symbol" class="align-self-center" :src="plus" @click="addClientIdToDelete" alt="Add" />
                </div>
            </div>
            <div class="card shadow">
                <div class="d-flex font-grey pl-2">
                    <div class="items-opened first-column">Client ID To Keep:</div>
                    <div class="items-opened">{{ clientIdToKeep }}</div>
                </div>
                <div class="d-flex font-grey pl-2">
                    <div class="items-opened first-column">Client IDs To Delete:</div>
                    <div v-for="clientId in clientIdsToRemove" class="items-opened flex-column">
                        {{ clientId }}
                    </div>
                </div>
                <button @click="toggleShowAuditModal" @keyup.enter="toggleShowAuditModal" type="button" class="green-btn mb-3 mr-3 align-self-end"
                        :class="{disabled: $v.$invalid}" :disabled="$v.$invalid">
                    Delete Duplicates
                </button>
            </div>
        </div>
    </fieldset>

</template>

<script>
    import {required, numeric} from 'vuelidate/lib/validators';
    import AuditReasonModal from "../../AuditReasonModal";

    export default {
        name: "DuplicateFileIVA",
        components: {
            AuditReasonModal
        },
        props: {
            errorMessage: Function
        },
        data() {
            return {
                clientIdToKeep: null,
                clientIdToRemove: null,
                clientIdsToRemove: [],
                reason: '',
                loading: false,
                doShowAuditModal: false,
                plus: this.$sharedImages + '/plus1.svg'
            }
        },
        validations: {
            clientIdToKeep: {required},
            clientIdsToRemove: {required}
        },
        methods: {
            checkNumeric(event) {
                if (event.key != "Backspace" && event.key != "Delete" && event.key != "ArrowRight" && event.key != "ArrowLeft" && event.key != "c" && event.key != "v") {
                    if (!/[0-9]/.test(event.key)) event.preventDefault();
                }
            },
            addClientIdToDelete() {
                this.clientIdsToRemove.push(this.clientIdToRemove);
                this.clientIdToRemove = null;
            },
            deleteDuplicateFiles() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.loading = true;

                const clientIds = {
                    client_id_to_keep: vm.clientIdToKeep,
                    client_ids_to_remove: vm.clientIdsToRemove,
                    reason: vm.reason
                }

                axios
                    .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$duplicateFile + vm.$debtsolvIvaView, clientIds, {
                        headers: {"Authorization": `Bearer ${bearerToken}`}
                    })
                    .then(response => {
                        vm.successMessage();
                        vm.clientIdToKeep = null;
                        vm.clientIdsToRemove = [];
                        vm.reason = '';
                    })
                    .catch(error => {
                        vm.errorMessage();
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
                this.deleteDuplicateFiles();
            },
            successMessage() {
                this.$swal.fire({
                    icon: 'success',
                    title: 'Duplicate File(s) Deleted!'
                });
            },
            errorMessage() {
                this.$swal.fire({
                    icon: 'error',
                    title: 'There are no duplicate files to remove!'
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .font-grey {
        color: #666;
    }
</style>

