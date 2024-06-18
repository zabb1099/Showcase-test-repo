<template>
    <transition name="modal">
        <div class="modal fade" id="edit-modal" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h3 class="modal-title">Edit User Station</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Desk Name</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.DeskName">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Computer Name</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.ComputerName">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Assigned To</label>
                                    <select class="form-field" v-model="selectedAttribute.AssignedTo">
                                        <option selected v-for="user in attributes.users" :value="user">
                                            {{ user.USR_Full_Name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Bank No</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.BankNo">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">PC No
                                        <span class="validation-error" v-if="!$v.selectedAttribute.PCNo.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text"
                                           v-model.trim="$v.selectedAttribute.PCNo.$model">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">OS</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.OS">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">RAM</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.RAM">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Processor</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.Processor">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">MS Office Version</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.OS">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Has Dual Monitors</label>
                                    <select class="form-field" v-model="selectedAttribute.IsDualMonitors">
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
                        <button type="button"
                                class="blue-btn"
                                data-dismiss="modal"
                                @click="closeEditModal">
                            &#10005; Cancel
                        </button>
                        <button @click="updateAttribute()"
                                type="button"
                                class="green-btn"
                                id="edit-button-user-stations"
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
import {required} from "vuelidate/lib/validators";

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
            PCNo: {
                required
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
                DeskName: this.selectedAttribute.DeskName,
                ComputerName: this.selectedAttribute.ComputerName,
                AssignedTo: this.selectedAttribute.AssignedTo.USR_ID,
                BankNo: this.selectedAttribute.BankNo,
                PCNo: this.selectedAttribute.PCNo,
                OS: this.selectedAttribute.OS,
                RAM: this.selectedAttribute.RAM,
                Processor: this.selectedAttribute.Processor,
                MSOfficeVersion: this.selectedAttribute.MSOfficeVersion,
                IsDualMonitors: this.selectedAttribute.IsDualMonitors,
                Notes: this.selectedAttribute.Notes,
                LastUpdatedBy: JSON.parse(localStorage.getItem('session')).USR_ID,
                LastUpdatedOn: new Date().toISOString().slice(0, 19).replace('T', ' ')
            }
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .put(vm.$baseUrl + vm.$userStationsUrl + '/' + vm.selectedAttribute.ID, newAttribute, {
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
