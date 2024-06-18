<template>
    <transition name="modal">
        <div class="modal fade" id="create-modal" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h5 class="modal-title">Create Bulk Creditor</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Creditor ID
                                        <span class="validation-error" v-if="!$v.creditor_id.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="number" v-model.trim="$v.creditor_id.$model">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Creditor Name
                                        <span class="validation-error" v-if="!$v.creditor_name.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model.trim="$v.creditor_name.$model">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">To Email
                                        <span class="validation-error" v-if="!$v.to_email.required">
                                            {{ $requiredText }}
                                        </span>
                                        <span class="validation-error" v-if="!$v.to_email.email">
                                            {{ $emailText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="email" v-model.trim="$v.to_email.$model">
                                </div>
                                <div class="form-flex-item-job no-border-bottom">
                                    <label class="form-label">CC Email</label>
                                    <input class="form-field" type="text" v-model="cc_email">
                                </div>
                                <div class="form-flex-item-job">
                                    <p>(Use (;) to separate multiple e-mail addresses.)</p>
                                </div>
                                <div class="form-flex-item-job no-border-bottom">
                                    <label class="form-label">Reason For Creating
                                        <span class="validation-error" v-if="!$v.audit_reason.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model.trim="$v.audit_reason.$model">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="closeCreateModal"
                                type="button"
                                class="blue-btn"
                                data-dismiss="modal">
                            &#10005; Cancel
                        </button>
                        <button @click="createBulkCreditor()"
                                class="search-btn green-btn"
                                data-dismiss="modal"
                                :class="{disabled: $v.$invalid}"
                                :disabled="$v.$invalid">
                            &#10003; Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import {required,email} from 'vuelidate/lib/validators';

    export default {
        name: "CreateModal",
        props: {
            getBulkCreditor: Function,
            errorMessage: Function
        },
        validations: {
            audit_reason: {required},
            to_email: {required, email},
            creditor_id: {required},
            creditor_name: {required}
        },
        data() {
            return {
                audit_reason: '',
                creditor_id: '',
                creditor_name: '',
                to_email: '',
                cc_email: '',
                updating: false,
                loading: false,
                errorMessageText: 'Error!'
            }
        },
        methods: {
            closeCreateModal() {
                this.showCreateModal = false;
                this.$emit('hideCreateModal', this.showCreateModal);
            },
            createBulkCreditor() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.updating = true;
                vm.$emit('setUpdateStatus', vm.updating);

                vm.loading = true;
                vm.$emit('setLoadingStatus', vm.loading);

                const creditorData = {
                    creditor_id: vm.creditor_id,
                    creditor_name: vm.creditor_name,
                    to_email: vm.to_email,
                    cc_email: vm.cc_email,
                    reason: vm.audit_reason
                }

                axios
                    .post(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$bulkCreditor + vm.$debtsolvDmView, creditorData, {
                        headers: {"Authorization": `Bearer ${bearerToken}`}
                    })
                    .then(response => {
                        vm.$emit('setCreditorID', vm.creditor_id);
                        vm.auditReason = '';
                        vm.getBulkCreditor();
                    })
                    .catch(error => {
                        vm.errorMessageText = error.response.data.errors.creditor_id[0];

                        vm.$swal({
                            icon: 'error',
                            title: vm.errorMessageText
                        });

                        vm.loading = false;
                        vm.$emit('setLoadingStatus', vm.loading);
                    })
                    .finally(() => {
                        vm.closeCreateModal();
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>

    .form-label {
        flex-basis: 35%;
    }

    p {
        text-transform: none !important;
        padding-bottom: 2px;
    }

</style>
