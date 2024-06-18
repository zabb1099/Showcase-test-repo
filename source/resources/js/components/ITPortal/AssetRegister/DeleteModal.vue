<template>
    <transition name="modal">
        <div class="modal fade" id="delete-modal" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="delete-title modal-header">
                        <h3 class="modal-title-delete">Confirmation</h3>
                    </div>
                    <div class="modal-body-delete">
                        <p v-if="selectedAttribute.Name" class="modal-body-text">Do you really want to delete this
                            Asset with the Name '{{ selectedAttribute.Name }}'?</p>
                        <p v-else class="modal-body-text">Do you really want to delete this Asset?</p>
                    </div>
                    <div class="modal-footer">
                        <button @click="deleteAttribute()"
                                type="button"
                                class="blue-btn"
                                data-dismiss="modal">
                            Yes, delete
                        </button>
                        <button @click="closeDeleteModal"
                                type="button"
                                class="green-btn"
                                data-dismiss="modal">
                            No, cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "DeleteModal",
    props: {
        selectedAttribute: Object,
        getAttributes: Function,
        successMessage: Function,
        errorMessage: Function
    },
    methods: {
        closeDeleteModal() {
            this.showDeleteModal = false
            this.$emit('hideDeleteModal', this.showDeleteModal);

        },
        deleteAttribute() {
            let vm = this;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .delete(vm.$baseUrl + vm.$assetRegisterUrl + '/' + vm.selectedAttribute.ID, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.closeDeleteModal();
                    vm.getAttributes();
                    vm.successMessage();
                })
                .catch(error => {
                    vm.errorMessage();
                });
        },
    }
}
</script>
