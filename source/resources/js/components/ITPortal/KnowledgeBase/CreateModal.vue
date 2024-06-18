<template>
    <transition name="modal">
        <div class="modal fade" id="create-modal" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h3 class="modal-title">Create New Issue</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Short Name
                                        <span class="validation-error" v-if="!$v.Short_Name.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text" v-model.trim="$v.Short_Name.$model">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Project</label>
                                    <select class="form-field" v-model="ITP_ID">
                                        <option selected value="">-- Please Select Project --</option>
                                        <option v-for="project in attributes.itProjects" :value="project.ITP_ID">
                                            {{ project.project_name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Team To Resolve</label>
                                    <select class="form-field" v-model="TEAM_ID">
                                        <option selected value="">-- Please Select Team --</option>
                                        <option v-for="team in attributes.teamNames" :value="team.TEAM_ID">
                                            {{ team.team_name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Issue Type</label>
                                    <input class="form-field" type="text" v-model="Issue_Type">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Issue Description</label>
                                    <textarea class="form-field height-reset"
                                              rows="12"
                                              type="input"
                                              v-model="Issue_Description">
                                    </textarea>
                                </div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Solution Description</label>
                                    <textarea class="form-field height-reset"
                                              rows="14"
                                              type="input"
                                              v-model="Solution_Description"
                                    ></textarea>
                                </div>
                                <div>
                                    <input type="hidden" v-model="Created_By">
                                </div>
                                <div>
                                    <input type="hidden" v-model="Date_Created">
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
                                id="create-button-knowledge-base"
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
            ITL_ID: '',
            Short_Name: '',
            ITP_ID: '',
            TEAM_ID: '',
            Issue_Type: '',
            Issue_Description: '',
            Solution_Description: '',
            Created_By: '',
            Date_Created: '',
            USR_ID: ''
        }
    },
    validations: {
        Short_Name: {
            required
        }
    },
    methods: {
        closeCreateModal() {
            this.showCreateModal = false;
            this.$emit('hideCreateModal', this.showCreateModal);
        },
        createAttribute() {
            const newAttribute = {
                Short_Name: this.Short_Name,
                ITP_ID: this.ITP_ID,
                TEAM_ID: this.TEAM_ID,
                Issue_Type: this.Issue_Type,
                Issue_Description: this.Issue_Description,
                Solution_Description: this.Solution_Description,
                Created_By: JSON.parse(localStorage.getItem('session')).USR_ID,
                Date_Created: new Date().toISOString().slice(0, 19).replace('T', ' '),
            };
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .post(vm.$baseUrl + vm.$knowledgeBaseUrl, newAttribute, {
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
