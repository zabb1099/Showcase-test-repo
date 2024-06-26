<template>
    <fieldset :disabled="loading" class="loadingSpinner pageSize">
        <div class="loader" v-if="loading"></div>
        <div v-if="showEditModal">
            <edit-modal
                :getLeadsUser="getLeadsUser"
                :selectedUser="selectedUser"
                @setUpdateStatus="setUpdateStatus"
                @setLoadingStatus="setLoadingStatus"
                @hideEditModal="hideModals"
                :errorMessage="errorMessage">
            </edit-modal>
        </div>
        <div v-if="showDeleteModal">
            <delete-modal
                :getLeadsUser="getLeadsUser"
                :selectedUser="selectedUser"
                @setUpdateStatus="setUpdateStatus"
                @setLoadingStatus="setLoadingStatus"
                @hideDeleteModal="hideModals"
                :errorMessage="errorMessage">
            </delete-modal>
        </div>
        <div class="mt-3">
            <div class="card shadow py-3 mb-3">
                <div class="form-flex-item-job no-border-bottom">
                    <label class="form-label">Agent's Name</label>
                    <input class="form-field-job" type="text" v-model.trim="$v.userFullName.$model">
                    <button @click="getLeadsUser()"
                            class="search-btn blue-btn"
                            :class="{disabled: $v.$invalid}"
                            :disabled="$v.$invalid">
                        {{ isSearching ? "Searching..." : "Search" }}
                    </button>
                </div>
            </div>
            <form class="form-flex" @submit.prevent>
                <div v-if="noData">
                    <div class="main card shadow">
                        <h2 class="pt-3 pb-2 main-header">User not found!</h2>
                    </div>
                </div>
                <div v-if="leadsUser.length" class="pb-3">
                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex1">User ID</div>
                        <div class="items-header flex2">Leads Username</div>
                        <div class="items-header flex2">Name</div>
                        <div class="items-header flex2">Department</div>
                        <div class="items-header flex2">Phoenix V1 Username</div>
                        <div class="items-header flex1">Status</div>
                        <div class="items-header flex2"></div>
                    </div>
                    <div class="shadow main-table" v-for="data in leadsUser" :key="data.id">
                        <div class="table-flex-opened font-change">
                            <div class="items-opened flex1 first-column">{{ data.id }}</div>
                            <div class="items-opened flex2">{{ data.leads_username }}</div>
                            <div class="items-opened flex2">{{ data.user_full_name }}</div>
                            <div class="items-opened flex2">{{ data.user_department.name }}</div>
                            <div class="items-opened flex2">{{ data.phoenix_username }}</div>
                            <div class="items-opened flex1">{{ data.phoenix_status }}</div>
                            <div class="items-opened flex2 pl-3">
                                  <span class="pr-3">
                                    <img @click="editModal(data)"
                                         id="pencil-symbol"
                                         :src="images.pencil"
                                         alt="Edit"
                                         data-toggle="modal"
                                         data-target="#edit-modal"/>
                                </span>
                                <span>
                                    <img @click="deleteModal(data)"
                                         id="trash-symbol"
                                         :src="images.trash"
                                         alt="Delete"
                                         data-toggle="modal"
                                         data-target="#delete-modal"/>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
</template>

<script>
import {required} from 'vuelidate/lib/validators';
import DeleteModal from "./DeleteModal";
import EditModal from "./EditModal";

export default {
    name: "CreatePhoenixLogin",
    components: {
        EditModal,
        DeleteModal
    },
    props: {
        errorMessage: Function
    },
    data() {
        return {
            userData: {},
            selectedUser: {},
            leadsUser: [],
            updateSingleUser: [],
            userFullName: '',
            isSearching: false,
            noData: false,
            loading: false,
            updating: false,
            showDeleteModal: false,
            showEditModal: false,
            images: {
                pencil: this.$sharedImages + '/edit.svg',
                trash: this.$sharedImages + '/delete.svg'
            },
        }
    },
    validations: {
        userFullName: {
            required
        }
    },
    methods: {
        getLeadsUser() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.loading = true;

            if (!vm.updating) {
                vm.isSearching = true;
            }

            axios
                .get(vm.$baseUrl + vm.$devSupportJobsUrl + vm.$leadsUser + vm.$createPhoenixLogin, {
                    params: {
                        user_full_name: vm.userFullName
                    },
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.userData = response.data;
                    vm.nullToEmptyString(vm.userData.leadsUser);
                    vm.leadsUser.length ? vm.noData = false : vm.noData = true;
                    vm.isSearching = false;
                    vm.loading = false;

                    if (vm.updating) {
                        vm.successMessage();
                    }
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.updating = false;
                });
        },
        nullToEmptyString(object) {
            object.forEach((item) => {
                Object.keys(item).forEach((key) => {
                    if (item[key] === null) {
                        item[key] = '';
                    }
                });
            });
            this.leadsUser = object;
        },
        setUpdateStatus(updateStatus) {
            this.updating = updateStatus;
        },
        setLoadingStatus(loadingStatus) {
            this.loading = loadingStatus;
        },
        editModal(user) {
            this.showEditModal = true;
            this.showDeleteModal = false;
            this.selectedUser = user;
        },
        deleteModal(user) {
            this.showEditModal = false;
            this.showDeleteModal = true;
            this.selectedUser = user;
        },
        hideModals(e) {
            this.showEditModal = e;
            this.showDeleteModal = e;
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'Phoenix V1 login update successful!'
            });
        }
    }
}
</script>
