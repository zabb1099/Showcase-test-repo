<template>
    <fieldset :disabled="loading" class="loadingSpinner">
        <div class="loader" v-if="loading"/>
        <div v-if="showCreateModal">
            <CreateModal :getBulkCreditor="getBulkCreditor" @setUpdateStatus="setUpdateStatus" @setCreditorID="setCreditorID" @setLoadingStatus="setLoadingStatus" @hideCreateModal="hideModals" :errorMessage="errorMessage"/>
        </div>
        <div v-if="showEditModal">
            <EditModal :getBulkCreditor="getBulkCreditor" :selectedCreditor="selectedCreditor" @setUpdateStatus="setUpdateStatus" @setLoadingStatus="setLoadingStatus" @hideEditModal="hideModals" :errorMessage="errorMessage"/>
        </div>
        <div class="mt-3">
            <div class="card shadow p-4 mb-3">
                <div class="d-flex border-bottom-0">
                    <div>
                        <label>Creditor ID</label>
                        <input class="form-field-job ml-4" type="text" v-model="creditorId">
                        <button @click="getBulkCreditor()" class="blue-btn ml-4" :class="{ disabled: $v.$invalid }" :disabled="$v.$invalid">
                            {{ searching ? "Searching..." : "Search" }}
                        </button>
                    </div>
                    <button @click="createModal()" class="green-btn ml-auto" data-toggle="modal" data-target="#create-modal">
                        New Remittance
                    </button>
                </div>
            </div>
            <form class="form-flex" @submit.prevent>
                <div v-if="creditor !== null && creditor.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex1">ID</div>
                        <div class="items-header flex2">Name</div>
                        <div class="items-header flex3">To Email</div>
                        <div class="items-header flex4">CC Email</div>
                        <div class="items-header flex2">Edit</div>
                    </div>
                    <div class="shadow main-table" v-for="data in creditor" :key="data.ID">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex1 first-column">{{ data.CreditorID }}</div>
                            <div class="items-opened flex2">{{ data.Name }}</div>
                            <div class="items-opened flex3">{{ data.ToEmail }}</div>
                            <div class="items-opened flex4">{{ data.CCEmail }}</div>
                            <div class="items-opened flex2 pl-3">
                                <span class="pr-3">
                                    <img @click="editModal(data)" :src="images.pencil" alt="Edit" id="pencil-symbol" data-toggle="modal" data-target="#edit-modal"/>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="creditor !== null && !creditor.length" class="main card shadow">
                    <h2 class="pt-3 pb-2 main-header">Creditor not found!</h2>
                </div>
            </form>
        </div>
    </fieldset>
</template>

<script>
    import {required} from 'vuelidate/lib/validators';
    import CreateModal from "./CreateModal";
    import EditModal from "./EditModal";

    export default {
        name: "BulkCreditorDM",
        components: {
            CreateModal,
            EditModal
        },
        props: {
            errorMessage: Function
        },
        data() {
            return {
                creditor: null,
                selectedCreditor: {},
                creditorId: '',
                searching: false,
                loading: false,
                updating: false,
                showCreateModal: false,
                showEditModal: false,
                images: {
                    plus: this.$sharedImages + '/plus1.svg',
                    pencil: this.$sharedImages + '/edit.svg'
                }
            }
        },
        validations: {
            creditorId: {
                required
            }
        },
        methods: {
            getBulkCreditor() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;

                vm.loading = true;
                if (!vm.updating) vm.searching = true;

                axios
                    .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$bulkCreditor + vm.$debtsolvDmView, {
                        params: { creditor_id: vm.creditorId },
                        headers: { "Authorization": `Bearer ${bearerToken}` }
                    })
                    .then(response => {
                        vm.creditor = response.data;
                        vm.searching = false;
                        vm.loading = false;
                        if (vm.updating) vm.successMessage();
                    })
                    .catch(error => {
                        vm.errorMessage();
                    })
                    .finally(() => {
                        vm.updating = false;
                    });
            },
            setUpdateStatus(updateStatus) {
                this.updating = updateStatus;
            },
            setLoadingStatus(loadingStatus) {
                this.loading = loadingStatus;
            },
            setCreditorID(creditorId) {
              this.creditorId = creditorId;
            },
            createModal(creditor) {
                this.showCreateModal = true;
                this.showEditModal = false;
                this.selectedCreditor = creditor;
            },
            editModal(creditor) {
                this.showCreateModal = false;
                this.showEditModal = true;
                this.selectedCreditor = creditor
            },
            hideModals(e) {
                this.showCreateModal = e;
                this.showEditModal = e;
            },
            successMessage() {
                this.$swal.fire({
                    icon: 'success',
                    title: 'Success!'
                });
            }
        }
    }
</script>

<style lang="scss" scoped>

    label {
        font-weight: bold;
        font-size: 0.9rem;
        text-transform: uppercase;
        color: #666;
    }

</style>
