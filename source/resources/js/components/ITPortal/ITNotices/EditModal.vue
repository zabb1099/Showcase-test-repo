<template>
    <transition name="modal">
      <div class="modal fade" id="update-modal" role="dialog">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="title-header modal-header">
                            <h3 class="modal-title">
                                Update Notice
                            </h3>
                         </div>
                        <div class="modal-body">
                            <div class="container">
                                <div>
                                    <form class="form-flex">
                                        <div class="form-flex-item">
                                            <label class="form-label">Notice Header</label>
                                            <input class="form-field" type="text" v-model="selectedAttribute.notice_header">
                                        </div>
                                        <div class="form-flex-item">
                                            <label class="form-label">Notice Body</label>
                                            <textarea class="form-field" v-model="selectedAttribute.notice_body">
                                            </textarea>
                                        </div>
                                        <div class="form-flex-item">
                                            <label class="form-label">Priority Level</label>
                                            <select class="form-field" v-model="selectedAttribute.priority_level">
                                             <option selected value="">-- Select Priority Level --</option>
                                             <option>Low</option>
                                             <option>Medium</option>
                                             <option>High</option>
                                         </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="red-btn"
                                id="update_modal_close"
                                data-dismiss="modal">
                            Cancel
                        </button>
                            <button @click="updateAttribute()"
                                type="button"
                                class="green-btn"
                                id="edit-button-it-notice"
                                data-dismiss="modal">
                            &#10003; Update
                        </button>
                        </div>
                    </div>
                </div>
            </div>
    </transition>
</template>

<script>

export default {

    name: "UpdateModal",

    props: {
        selectedAttribute: Object
    },

    methods: {

        updateAttribute() {
            const newAttribute = {
                notice_header: this.selectedAttribute.notice_header,
                notice_body: this.selectedAttribute.notice_body,
                priority_level: this.selectedAttribute.priority_level,
                updated_by: JSON.parse(localStorage.getItem('session')).USR_ID
            }
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .put(vm.$baseUrl + vm.$noticeBoardUrl + '/' + vm.selectedAttribute.id, newAttribute, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    window.location.reload();
                })
                .catch(error => {
                     console.log(error)
                });
        }
    }
}
</script>
