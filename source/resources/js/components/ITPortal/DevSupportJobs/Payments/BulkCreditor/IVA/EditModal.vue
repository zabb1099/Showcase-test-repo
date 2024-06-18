<template>
    <transition name="modal">
        <div class="modal fade" id="edit-modal" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h5 class="modal-title">Update Bulk Creditor: {{ selectedCreditor.CreditorID }} - {{ selectedCreditor.Name }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Creditor ID</label>
                                    <input class="form-field" type="number" disabled v-model="selectedCreditor.CreditorID">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Creditor Name</label>
                                    <input class="form-field" type="text" disabled v-model="selectedCreditor.Name">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Bulk Creditor ID
                                        <span class="validation-error" v-if="!$v.selectedCreditor.BulkCreditorID.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="number" v-model.trim="$v.selectedCreditor.BulkCreditorID.$model">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">To Email
                                        <span class="validation-error" v-if="!$v.selectedCreditor.ToEmail.required">
                                            {{ $requiredText }}
                                        </span>
                                        <span class="validation-error" v-if="!$v.selectedCreditor.ToEmail.email">
                                            {{ $emailText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="email" v-model.trim="$v.selectedCreditor.ToEmail.$model">
                                </div>
                                <div class="form-flex-item-job no-border-bottom">
                                    <label class="form-label">CC Email</label>
                                    <input class="form-field" type="text" v-model="selectedCreditor.CCEmail">
                                </div>
                                <div class="form-flex-item-job">
                                    <p>(Use (;) to separate multiple e-mail addresses.)</p>
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">From Email
                                        <span class="validation-error" v-if="!$v.selectedCreditor.FromEmail.required">
                                            {{ $requiredText }}
                                        </span>
                                        <span class="validation-error" v-if="!$v.selectedCreditor.FromEmail.email">
                                            {{ $emailText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="email" v-model.trim="$v.selectedCreditor.FromEmail.$model">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Contact Type
                                        <span class="validation-error" v-if="!$v.selectedCreditor.ContactType.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="number" v-model.trim="$v.selectedCreditor.ContactType.$model">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">File Password
                                        <span class="validation-error" v-if="!$v.selectedCreditor.FilePassword.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model.trim="$v.selectedCreditor.FilePassword.$model">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Email Template ID
                                        <span class="validation-error" v-if="!$v.selectedCreditor.EmailTemplateID.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="number" v-model.trim="$v.selectedCreditor.EmailTemplateID.$model">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Bulk Email Group ID</label>
                                    <input class="form-field" type="number" v-model="selectedCreditor.BulkEmailGroupID">
                                </div>
                                <div class="form-flex-item-job no-border-bottom">
                                    <label class="form-label">Reason For Update
                                        <span class="validation-error" v-if="!$v.auditReason.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model="auditReason" v-model.trim="$v.auditReason.$model">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="closeEditModal"
                                type="button"
                                class="blue-btn"
                                data-dismiss="modal">
                            &#10005; Cancel
                        </button>
                        <button @click="updateBulkCreditor()"
                                class="search-btn green-btn"
                                data-dismiss="modal"
                                :class="{disabled: $v.$invalid}"
                                :disabled="$v.$invalid">
                            &#10003; Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import {email, required} from 'vuelidate/lib/validators';

    export default {
        name: "EditModal",
        props: {
            selectedCreditor: Object,
            getBulkCreditor: Function,
            errorMessage: Function
        },
        validations: {
            auditReason: {required},
            selectedCreditor: {
                BulkCreditorID: {required},
                ToEmail: {required, email},
                FromEmail: {required, email},
                ContactType: {required},
                FilePassword: {required},
                EmailTemplateID: {required}
            }
        },
        data() {
            return {
                auditReason: '',
                updating: false,
                loading: false
            }
        },
        methods: {
            closeEditModal() {
                this.showEditModal = false
                this.$emit('hideEditModal', this.showEditModal);
            },
            updateBulkCreditor() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.updating = true;
                vm.$emit('setUpdateStatus', vm.updating);

                vm.loading = true;
                vm.$emit('setLoadingStatus', vm.loading);

                const creditorData = {
                    id: vm.selectedCreditor.ID,
                    bulk_creditor_id: vm.selectedCreditor.BulkCreditorID,
                    to_email: vm.selectedCreditor.ToEmail,
                    cc_email: vm.selectedCreditor.CCEmail,
                    from_email: vm.selectedCreditor.FromEmail,
                    contact_type: vm.selectedCreditor.ContactType,
                    file_password: vm.selectedCreditor.FilePassword,
                    email_template_id: vm.selectedCreditor.EmailTemplateID,
                    bulk_email_group_id: vm.selectedCreditor.BulkEmailGroupID,
                    reason: vm.auditReason
                }

                axios
                    .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$bulkCreditor + vm.$debtsolvIvaView, creditorData, {
                        headers: {"Authorization": `Bearer ${bearerToken}`}
                    })
                    .then(response => {
                        vm.auditReason = '';
                    })
                    .catch(error => {
                        vm.errorMessage();
                    })
                    .finally(() => {
                        vm.closeEditModal();
                        vm.getBulkCreditor();
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
