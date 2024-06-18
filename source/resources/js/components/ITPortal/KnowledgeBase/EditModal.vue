<template>
    <transition name="modal">
        <div class="modal fade" id="edit-modal" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h3 class="modal-title">Edit Issue</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item">
                                    <label class="form-label">Short Name
                                        <span class="validation-error" v-if="!$v.selectedAttribute.Short_Name.required">
                                            {{ $requiredText }}
                                        </span>
                                    </label>
                                    <input class="form-field" type="text"
                                           v-model.trim="$v.selectedAttribute.Short_Name.$model">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Project</label>
                                    <select class="form-field" v-model="selectedAttribute.ITP_ID">
                                        <option v-for="project in attributes.itProjects" :value="project.ITP_ID">
                                            {{ project.project_name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Team To Resolve</label>
                                    <select class="form-field" v-model="selectedAttribute.TEAM_ID">
                                        <option v-for="team in attributes.teamNames" :value="team.TEAM_ID">
                                            {{ team.team_name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Issue Type</label>
                                    <input class="form-field" type="text" v-model="selectedAttribute.Issue_Type">
                                </div>
                                <div class="form-flex-item">
                                    <label class="form-label">Issue Description</label>
                                    <textarea class="form-field height-reset"
                                              rows="12"
                                              type="input"
                                              v-model="selectedAttribute.Issue_Description">
                                    </textarea>
                                </div>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Solution Description</label>
                                    <textarea class="form-field height-reset"
                                              rows="14"
                                              type="input"
                                              v-model="selectedAttribute.Solution_Description">
                                    </textarea>
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
                                id="edit-button-knowledge-base"
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
import {required} from 'vuelidate/lib/validators';

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
            Short_Name: {
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
                ITL_ID: this.selectedAttribute.ITL_ID,
                Short_Name: this.selectedAttribute.Short_Name,
                ITP_ID: this.selectedAttribute.ITP_ID,
                TEAM_ID: this.selectedAttribute.TEAM_ID,
                Issue_Type: this.selectedAttribute.Issue_Type,
                Issue_Description: this.selectedAttribute.Issue_Description,
                Solution_Description: this.selectedAttribute.Solution_Description
            }
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .put(vm.$baseUrl + vm.$knowledgeBaseUrl + '/' + vm.selectedAttribute.ITL_ID, newAttribute, {
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
