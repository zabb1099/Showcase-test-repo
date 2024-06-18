<template>
    <transition name="modal">
        <div class="modal fade" id="edit-modal" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h3 class="modal-title">Edit Asset</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Name</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.Name">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Asset Type</label>
                                    <select class="form-field" v-model="selectedAttribute.Asset_Type">
                                        <option value="Laptop">Laptop</option>
                                        <option value="PC">PC</option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Model</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.Model">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Serial No</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.Serial_No">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Zero Tier IP LPT</label>
                                    <input class="form-field" type="text"
                                           v-model="selectedAttribute.ZeroTier_IP_LPT">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Zero Tier IP PC</label>
                                    <input class="form-field" type="text"
                                           v-model="selectedAttribute.Zero_Tier_IP_PC">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Employee Name</label>
                                    <select class="form-field" v-model="selectedAttribute.EmployeeName">
                                        <option v-for="user in attributes.users" :value="user">
                                            {{ user.USR_Full_Name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Username</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.LP_username">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Password</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.LP_password">
                                </div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Date Given
                                        <span class="validation-error" v-if="!$v.selectedAttribute.Date_Given.dateFormat">
                                                {{ $dateFormatText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model.trim="$v.selectedAttribute.Date_Given.$model">
                                </div>
                                <div>
                                    <input type="hidden" v-model="selectedAttribute.Last_Updated_By">
                                    <input type="hidden" v-model="selectedAttribute.Last_Updated_On">
                                    <input type="hidden" v-model="selectedAttribute.EMP_ID">
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
                                id="edit-button-asset-register"
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
import moment from "moment";
import {helpers} from 'vuelidate/lib/validators';

const dateFormat = helpers.regex('dateFormat', /[0-9]{4}[\-][0-9]{2}[\-][0-9]{2}$/);

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
            Date_Given: {
                dateFormat
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
                Name: this.selectedAttribute.Name,
                Asset_Type: this.selectedAttribute.Asset_Type,
                Model: this.selectedAttribute.Model,
                Serial_No: this.selectedAttribute.Serial_No,
                ZeroTier_IP_LPT: this.selectedAttribute.ZeroTier_IP_LPT,
                Zero_Tier_IP_PC: this.selectedAttribute.Zero_Tier_IP_PC,
                EMP_ID: this.selectedAttribute.EmployeeName.USR_ID,
                Last_Updated_By: JSON.parse(localStorage.getItem('session')).USR_ID,
                Last_Updated_On: new Date().toISOString().slice(0, 19).replace('T', ' '),
                EmployeeName: this.selectedAttribute.EmployeeName.USR_Full_Name,
                LP_username: this.selectedAttribute.LP_username,
                LP_password: this.selectedAttribute.LP_password,
                Date_Given: moment(this.selectedAttribute.Date_Given).format('YYYY-MM-DD HH:mm:ss')
            }
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .put(vm.$baseUrl + vm.$assetRegisterUrl + '/' + vm.selectedAttribute.ID, newAttribute, {
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
    },
    mounted() {
        this.selectedAttribute.Date_Given = moment(this.selectedAttribute.Date_Given).format('YYYY-MM-DD');
    }
}
</script>
