<template>
    <transition name="modal">
        <div class="modal fade" id="create-modal" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h3 class="modal-title">Create New Asset</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Name</label>
                                    <input class="form-field" type="text" v-model="Name">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Asset Type</label>
                                    <select class="form-field" v-model="Asset_Type">
                                        <option selected value="">-- Please Select Asset --</option>
                                        <option value="Laptop">Laptop</option>
                                        <option value="PC">PC</option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Model</label>
                                    <input class="form-field" type="text" v-model="Model">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Serial_No</label>
                                    <input class="form-field" type="text" v-model="Serial_No">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Zero Tier IP LPT</label>
                                    <input class="form-field" type="text" v-model="ZeroTier_IP_LPT">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Zero Tier IP PC</label>
                                    <input class="form-field" type="text" v-model="Zero_Tier_IP_PC">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Employee Name</label>
                                    <select class="form-field" v-model="EmployeeName">
                                        <option selected value="">-- Please Select Employee --</option>
                                        <option v-for="user in attributes.users" :value="user">
                                            {{ user.USR_Full_Name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Username</label>
                                    <input class="form-field" type="text" v-model="LP_username">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Password</label>
                                    <input class="form-field" type="text" v-model="LP_password">
                                </div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Date Given
                                        <span class="validation-error" v-if="!$v.Date_Given.dateFormat">
                                                {{ $dateFormatText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model.trim="$v.Date_Given.$model">
                                </div>
                                <div>
                                    <input type="hidden" v-model="Last_Updated_By">
                                    <input type="hidden" v-model="Date_Added">
                                    <input type="hidden" v-model="EMP_ID">
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
                                id="create-button-asset-register"
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
import moment from "moment";
import {helpers} from 'vuelidate/lib/validators';

const dateFormat = helpers.regex('dateFormat', /[0-9]{4}[\-][0-9]{2}[\-][0-9]{2}$/);

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
            Name: '',
            Asset_Type: '',
            Model: '',
            Serial_No: '',
            Date_Added: '',
            Last_Updated_By: '',
            ZeroTier_IP_LPT: '',
            Zero_Tier_IP_PC: '',
            EMP_ID: '',
            EmployeeName: '',
            LP_username: '',
            LP_password: '',
            Date_Given: moment().format('YYYY-MM-DD')
        }
    },
    validations: {
        Date_Given: {
            dateFormat
        }
    },
    methods: {
        closeCreateModal() {
            this.showCreateModal = false
            this.$emit('hideCreateModal', this.showCreateModal);
        },
        createAttribute() {
            const newAttribute = {
                Name: this.Name,
                Asset_Type: this.Asset_Type,
                Model: this.Model,
                Serial_No: this.Serial_No,
                ZeroTier_IP_LPT: this.ZeroTier_IP_LPT,
                Zero_Tier_IP_PC: this.Zero_Tier_IP_PC,
                EMP_ID: this.EmployeeName.USR_ID,
                Last_Updated_By: JSON.parse(localStorage.getItem('session')).USR_ID,
                Date_Added: new Date().toISOString().slice(0, 19).replace('T', ' '),
                EmployeeName: this.EmployeeName.USR_Full_Name,
                LP_username: this.LP_username,
                LP_password: this.LP_password,
                Date_Given: moment(this.Date_Given).format('YYYY-MM-DD HH:mm:ss')
            };
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .post(vm.$baseUrl + vm.$assetRegisterUrl, newAttribute, {
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
