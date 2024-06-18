<template>
    <transition name="modal">
        <div class="modal fade" id="edit-modal" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h5 class="modal-title">Update User: {{ selectedUser.user_first_name }} {{ selectedUser.user_last_name }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Username
                                        <span class="validation-error" v-if="!$v.selectedUser.username.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model="selectedUser.username">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">First Name
                                        <span class="validation-error" v-if="!$v.selectedUser.user_first_name.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model="selectedUser.user_first_name">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Last Name
                                        <span class="validation-error" v-if="!$v.selectedUser.user_last_name.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model="selectedUser.user_last_name">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">User Group</label>
                                    <select class="form-field" v-model="selectedUser.user_department.id">
                                        <option v-for="group in userGroups" :value="group.id">
                                            {{ group.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Email Address</label>
                                    <input class="form-field" type="text" v-model="selectedUser.user_email">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Phone Number</label>
                                    <input class="form-field" type="text" v-model="selectedUser.phone_number">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">DM Debtsolv User ID</label>
                                    <input class="form-field" type="text" v-model="selectedUser.dm_user_id">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">IVA Debtsolv User ID</label>
                                    <input class="form-field" type="text" v-model="selectedUser.iva_user_id">
                                </div>
                                <div class="form-flex-item-job">
                                    <label class="form-label">Password</label>
                                    <input class="form-field" type="text" v-model="password">
                                </div>
                                <div class="form-flex-item-job no-border-bottom">
                                    <label class="form-label">Reason For Update</label>
                                    <input class="form-field" type="text" v-model="auditReason">
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
                        <button @click="updateBFGPortalLogin()"
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
import {required} from 'vuelidate/lib/validators';

    export default {
        name: "EditModal",
        props: {
            selectedUser: Object,
            userGroups: Array,
            getFSSUser: Function,
            errorMessage: Function
        },
        validations: {
            auditReason: {required},
            selectedUser: {
                username: {required},
                user_first_name: {required},
                user_last_name: {required}
            }
        },
        data() {
            return {
                password: '',
                auditReason: '',
                isUpdating: false,
                isLoading: false
            }
        },
        methods: {
            closeEditModal() {
                this.showEditModal = false
                this.$emit('hideEditModal', this.showEditModal);
            },
            updateBFGPortalLogin() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.isUpdating = true;
                vm.$emit('setUpdateStatus', vm.isUpdating);

                vm.isLoading = true;
                vm.$emit('setLoadingStatus', vm.isLoading);

                const userData = {
                    user_id: vm.selectedUser.user_id,
                    username: vm.selectedUser.username,
                    user_first_name: vm.selectedUser.user_first_name,
                    user_last_name: vm.selectedUser.user_last_name,
                    user_full_name: vm.selectedUser.user_first_name + '' + vm.selectedUser.user_last_name,
                    permission_group: vm.selectedUser.user_department.id,
                    email_address: vm.selectedUser.user_email,
                    phone_number: vm.selectedUser.phone_number,
                    dm_debtsolv_user_id: vm.selectedUser.dm_user_id,
                    iva_debtsolv_user_id: vm.selectedUser.iva_user_id,
                    password_hash: vm.password,
                    reason: vm.auditReason
                }

                axios
                    .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$fssUser + vm.$updateBFGPortalLogin, userData, {
                        headers: { "Authorization": `Bearer ${bearerToken}` }
                    })
                    .then(response => {
                        vm.password = '';
                        vm.reason = '';
                        vm.getFSSUser();
                    })
                    .catch(error => {
                        vm.errorMessage();
                        vm.isLoading = false;
                        vm.$emit('setLoadingStatus', vm.isLoading);
                    })
                    .finally(() => {
                        vm.closeEditModal();
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>

    .form-label {
        flex-basis: 35%;
    }

</style>
