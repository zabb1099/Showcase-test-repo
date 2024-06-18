<template>
    <transition name="modal">
        <div class="modal fade" id="delete-modal" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="delete-title modal-header">
                        <h3 class="modal-title-delete">Confirmation</h3>
                    </div>
                    <div class="modal-body-delete">
                        <p class="modal-body-text">Do you really want to delete {{ selectedUser.user_full_name }}'s
                            Phoenix V1 account?</p>
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item"></div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Reason:</label>
                                    <input class="form-field" type="text" v-model.trim="$v.auditReason.$model">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="deletePhoenixLogin()"
                                type="button"
                                class="blue-btn"
                                data-dismiss="modal"
                                :class="{disabled: $v.$invalid}"
                                :disabled="$v.$invalid">
                            Yes, delete
                        </button>
                        <button @click="closeDeleteModal"
                                type="button"
                                class="green-btn"
                                data-dismiss="modal">
                            No, cancel
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
    name: "DeleteModal",
    props: {
        selectedUser: Object,
        getLeadsUser: Function,
        errorMessage: Function
    },
    validations: {
        auditReason: {
            required
        }
    },
    data() {
        return {
            auditReason: '',
            isUpdating: false
        }
    },
    methods: {
        closeDeleteModal() {
            this.showDeleteModal = false
            this.$emit('hideDeleteModal', this.showDeleteModal);
        },
        deletePhoenixLogin() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.isUpdating = true;
            vm.$emit('setUpdateStatus', vm.isUpdating);

            vm.isLoading = true;
            vm.$emit('setLoadingStatus', vm.isLoading);

            const userData = {
                user_id: vm.selectedUser.id,
                reason: vm.auditReason
            }

            axios
                .put(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadsUser + vm.$deletePhoenixLogin, userData, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.reason = '';
                    vm.closeDeleteModal();
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.getLeadsUser();
                });
        }
    }
}
</script>
