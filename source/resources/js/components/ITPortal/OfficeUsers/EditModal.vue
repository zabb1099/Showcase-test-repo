<template>
    <transition name="modal">
        <div class="modal fade" id="edit-modal" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h3 class="modal-title">Edit Office User</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Version</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.Version">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Key</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.Key">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Email
                                        <span class="validation-error" v-if="!$v.selectedAttribute.email.email">
                                            {{ $emailText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="email"
                                           v-model.trim="$v.selectedAttribute.email.$model">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Password</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.password">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">PC Name</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.PCName">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Username</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.UserName">
                                </div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-field height-reset"
                                              rows="6"
                                              type="input"
                                              v-model="selectedAttribute.Notes">
                                    </textarea>
                                </div>
                                <div>
                                    <input type="hidden" v-model="selectedAttribute.LastUpdatedBy">
                                </div>
                                <div>
                                    <input type="hidden" v-model="selectedAttribute.LastUpdatedOn">
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
                        <button @click="updateAttribute()"
                                type="button"
                                class="green-btn"
                                id="edit-button-office-users"
                                data-dismiss="modal"
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
import {email} from 'vuelidate/lib/validators';

export default {
    name: "EditModal",
    props: {
        selectedAttribute: Object,
        getAttributes: Function,
        attributes: Object,
        successMessage: Function,
        errorMessage: Function
    },
    validations: {
        selectedAttribute: {
            email: {
                email
            }
        }
    },
    methods: {
        closeEditModal() {
            this.showEditModal = false
            this.$emit('hideEditModal', this.showEditModal);
        },
        updateAttribute() {
            const newAttribute = {
                Version: this.selectedAttribute.Version,
                Key: this.selectedAttribute.Key,
                email: this.selectedAttribute.email,
                password: this.selectedAttribute.password,
                PCName: this.selectedAttribute.PCName,
                UserName: this.selectedAttribute.UserName,
                Notes: this.selectedAttribute.Notes,
                LastUpdatedBy: JSON.parse(localStorage.getItem('session')).USR_ID,
                LastUpdatedOn: new Date().toISOString().slice(0, 19).replace('T', ' ')
            }
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .put(vm.$baseUrl + vm.$officeUsersUrl + '/' + vm.selectedAttribute.ID, newAttribute, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.closeEditModal();
                    vm.successMessage();
                })
                .catch(error => {
                    vm.errorMessage();
                });
        }
    }
}
</script>
