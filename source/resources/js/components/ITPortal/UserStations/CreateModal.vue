<template>
    <transition name="modal">
        <div class="modal fade" id="create-modal" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h3 class="modal-title">Create New User Station</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Desk Name</label>
                                    <input class="form-field" type="text" v-model="DeskName">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Computer Name</label>
                                    <input class="form-field" type="text" v-model="ComputerName">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Assigned To</label>
                                    <select class="form-field" v-model="AssignedTo">
                                        <option selected value="">-- Please Select Employee --</option>
                                        <option v-for="user in attributes.users" :value="user">
                                            {{ user.USR_Full_Name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Bank No</label>
                                    <input class="form-field" type="text" v-model="BankNo">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">PC No
                                        <span class="validation-error" v-if="!$v.PCNo.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model.trim="$v.PCNo.$model">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">OS</label>
                                    <input class="form-field" type="text" v-model="OS">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">RAM</label>
                                    <input class="form-field" type="text" v-model="RAM">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Processor</label>
                                    <input class="form-field" type="text" v-model="Processor">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">MS Office Version</label>
                                    <input class="form-field" type="text" v-model="MSOfficeVersion">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Has Dual Monitors</label>
                                    <select class="form-field" v-model="IsDualMonitors">
                                        <option selected value="">-- Please Select --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-field"
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
                        <button
                            @click="createAttribute()"
                            type="button"
                            class="green-btn"
                            id="create-button-user-stations"
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
import {required} from 'vuelidate/lib/validators';

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
            DeskName: '',
            ComputerName: '',
            AssignedTo: '',
            BankNo: '',
            PCNo: '',
            OS: '',
            RAM: '',
            Processor: '',
            MSOfficeVersion: '',
            IsDualMonitors: '',
            AddedBy: '',
            AddedOn: '',
            Notes: ''
        }
    },
    validations: {
        PCNo: {
            required
        }
    },
    methods: {
        closeCreateModal() {
            this.showCreateModal = false
            this.$emit('hideCreateModal', this.showCreateModal);
        },
        createAttribute() {
            const newAttribute = {
                DeskName: this.DeskName,
                ComputerName: this.ComputerName,
                AssignedTo: this.AssignedTo.USR_ID,
                BankNo: this.BankNo,
                PCNo: this.PCNo,
                OS: this.OS,
                RAM: this.RAM,
                Processor: this.Processor,
                MSOfficeVersion: this.MSOfficeVersion,
                IsDualMonitors: this.IsDualMonitors,
                Notes: this.Notes,
                AddedBy: JSON.parse(localStorage.getItem('session')).USR_ID,
                AddedOn: new Date().toISOString().slice(0, 19).replace('T', ' '),
            };
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .post(vm.$baseUrl + vm.$userStationsUrl, newAttribute, {
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
