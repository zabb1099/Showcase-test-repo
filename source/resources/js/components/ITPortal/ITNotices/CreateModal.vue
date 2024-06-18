<template>
    <transition name="modal">
            <div class="modal fade" id="create-modal" role="dialog">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="title-header modal-header">
                            <h3 class="modal-title">
                                Create New Notice
                            </h3>
                         </div>
                        <div class="modal-body">
                            <div class="container">
                                <div>
                                    <form class="form-flex">
                                    <div class="form-flex-item">
                                        <label class="form-label">Header
                                            <span class="validation-error" v-if="!$v.notice_header.required">
                                                {{ $requiredText}}
                                            </span>
                                        </label>
                                        <input class="form-field" v-model="notice_header"
                                               type="text" placeholder="Please input Header">
                                    </div>
                                    <div class="form-flex-item">
                                        <label>Details</label>
                                        <input class="form-field" v-model="notice_body"
                                               type="text" placeholder="Please input Details">
                                    </div>
                                    <div class="form-flex-item">
                                        <label>Priority Level</label>
                                         <select class="form-field" v-model="priority_level">
                                             <option selected value="">-- Select Priority Level --</option>
                                             <option>Low</option>
                                             <option>Medium</option>
                                             <option>High</option>
                                         </select>
                                    </div>
                                        <div>
                                            <input type="hidden" v-model="created_at">
                                        </div>
                                        <div>
                                            <input type="hidden" v-model="created_by">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button @click="closeCreateModal"
                                    class="red-btn"
                                    data-toggle="modal"
                                    data-target="#create-modal"
                                    id="create_modal_close"
                            >Close</button>
                            <button @click="createAttibute" class="green-btn">Create</button>
                        </div>
                    </div>

                </div>
            </div>
    </transition>
</template>

<script>
import {required} from 'vuelidate/lib/validators'



export default {

    name: "CreateModal",
    props: {
        hideCreateModal: Function,
    },
    data() {
        return {
            notice_header: '',
            notice_body: '',
            priority_level: '',
            created_at: '',
            created_by: ''
        }
    },

    validations: {
        notice_header: {
            required
        },
        priority_level: {
            required
        }
    },

    methods: {
        closeCreateModal() {
            this.showcreateModal = false;
            this.$emit('hideCreateModal');
        },
        createAttibute() {
            const newAttribute = {
                notice_header: this.notice_header,
                notice_body: this.notice_body,
                priority_level: this.priority_level,
                created_at: new Date().toISOString().slice(0, 19).replace('T', ' '),
                created_by: JSON.parse(localStorage.getItem('session')).USR_ID,
            };
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;

            axios
            .post(vm.$baseUrl + vm.$noticeBoardUrl, newAttribute, {
                headers: {
                    "Authorization": `Bearer ${bearerToken}`
                }
                })
            .then (response=> {
                document.getElementById('create_modal_close').click()

            })
            .catch(error => {
                console.log(error)
            })
        }
    }
}
</script>
