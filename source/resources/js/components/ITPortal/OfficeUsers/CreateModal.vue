<template>
    <transition name="modal">
        <div class="modal fade" id="create-modal" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h3 class="modal-title">Create New Office User</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Version</label>
                                    <input class="form-field" type="text" v-model="Version">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Key</label>
                                    <input class="form-field" type="text" v-model="Key">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Email
                                        <span class="validation-error" v-if="!$v.email.email">{{ $emailText }}</span>
                                    </label>
                                    <input class="form-field" type="email" v-model.trim="$v.email.$model">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Password</label>
                                    <input class="form-field" type="text" v-model="password">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">PC Name</label>
                                    <input class="form-field" type="text" v-model="PCName">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Username</label>
                                    <input class="form-field" type="text" v-model="UserName">
                                </div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-field height-reset"
                                              rows="6"
                                              type="input"
                                              v-model="Notes">
                                    </textarea>
                                </div>
                                <div>
                                    <input type="hidden" v-model="AddedBy">
                                </div>
                                <div>
                                    <input type="hidden" v-model="AddedOn">
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
                        <button @click="createAttribute()"
                                type="button"
                                class="green-btn"
                                id="create-button-office-users"
                                data-dismiss="modal"
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
import {email} from 'vuelidate/lib/validators';

export default {
    name: "CreateModal",
    props: {
        getAttributes: Function,
        attributes: Object,
        successMessage: Function,
        errorMessage: Function
    },
    data() {
        return {
            ID: '',
            Version: '',
            Key: '',
            email: '',
            password: '',
            PCName: '',
            UserName: '',
            AddedBy: '',
            AddedOn: '',
            Notes: ''
        }
    },
    validations: {
        email: {
            email
        }
    },
    methods: {
        closeCreateModal() {
            this.showCreateModal = false
            this.$emit('hideCreateModal', this.showCreateModal);
        },
        createAttribute() {
            const newAttribute = {
                Version: this.Version,
                Key: this.Key,
                email: this.email,
                password: this.password,
                PCName: this.PCName,
                UserName: this.UserName,
                AddedBy: JSON.parse(localStorage.getItem('session')).USR_ID,
                AddedOn: new Date().toISOString().slice(0, 19).replace('T', ' '),
                Notes: this.Notes,
            };
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .post(vm.$baseUrl + vm.$officeUsersUrl, newAttribute, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.closeCreateModal();
                    vm.getAttributes();
                    vm.successMessage();
                })
                .catch(error => {
                    vm.errorMessage();
                });
        }
    }
}
</script>
