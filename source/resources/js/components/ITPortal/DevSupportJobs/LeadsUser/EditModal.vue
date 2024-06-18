<template>
    <transition name="modal">
        <div class="modal fade" id="edit-modal" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h5 class="modal-title">New Phoenix V1 Login</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Password:</label>
                                    <input class="form-field" type="text" v-model.trim="$v.password.$model">
                                </div>
                                <div v-if="selectedUser.user_department.id == 9" class="form-flex-item">
                                    <label class="form-label">DDI:</label>
                                    <input class="form-field" type="number" v-model="selectedUser.ddi">
                                </div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Reason:</label>
                                    <input class="form-field" type="text" v-model.trim="$v.auditReason.$model">
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
                        <button @click="createPhoenixLogin()"
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
import {required} from 'vuelidate/lib/validators';

export default {
    name: "EditModal",
    props: {
        selectedUser: Object,
        getLeadsUser: Function,
        errorMessage: Function
    },
    validations: {
        password: {
            required
        },
        auditReason: {
            required
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
        createPhoenixLogin() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.isUpdating = true;
            vm.$emit('setUpdateStatus', vm.isUpdating);

            vm.isLoading = true;
            vm.$emit('setLoadingStatus', vm.isLoading);

            const userData = {
                user_id: vm.selectedUser.id,
                username: vm.selectedUser.leads_username,
                ddi: vm.selectedUser.ddi,
                password_hash: vm.password,
                user_group: vm.selectedUser.user_department.id,
                reason: vm.auditReason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadsUser + vm.$createPhoenixLogin, userData, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.password = '';
                    vm.reason = '';
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.closeEditModal();
                    vm.getLeadsUser();
                });
        }
    }
}
</script>
