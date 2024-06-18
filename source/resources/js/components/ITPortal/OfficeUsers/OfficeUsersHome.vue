<template>
    <div class="loadingSpinner pageSize ">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div v-if="showCreateModal">
                <create-modal
                    :attributes="attributes"
                    :getAttributes="getAttributes"
                    @hideCreateModal="hideModals"
                    :errorMessage="errorMessage"
                    :successMessage="successMessage">
                </create-modal>
            </div>

            <div v-if="showEditModal">
                <edit-modal
                    :attributes="attributes"
                    :getAttributes="getAttributes"
                    :selectedAttribute="selectedAttribute"
                    @hideEditModal="hideModals"
                    :errorMessage="errorMessage"
                    :successMessage="successMessage">
                </edit-modal>
            </div>

            <div v-if="showDeleteModal">
                <delete-modal
                    :getAttributes="getAttributes"
                    :selectedAttribute="selectedAttribute"
                    @hideDeleteModal="hideModals"
                    :errorMessage="errorMessage"
                    :successMessage="successMessage">
                </delete-modal>
            </div>

            <div class="bk-colour-grey">
                <div class="col-md-12">

                    <div class="my-4">
                        <search-bar
                            :attributes="attributes"
                            :images="images"
                            @setSearch="setSearchParams"
                            @resetSearch="resetSearchParams">
                        </search-bar>
                    </div>
                    <div class="mb-4 clearfix">
                        <button @click="createModal"
                                class="float-right green-btn"
                                data-toggle="modal"
                                data-target="#create-modal">
                            Add New
                        </button>
                    </div>

                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex1"></div>
                        <div class="items-header flex1">Version</div>
                        <div class="items-header flex5">Key</div>
                        <div class="items-header flex2">Date Created</div>
                        <div class="items-header flex4">Email</div>
                        <div class="items-header flex2">Created By</div>
                        <div class="items-header flex1"></div>
                    </div>

                    <div class="shadow main-table" v-for="officeUser in officeUserData" :key="officeUser.ID">
                        <div class="table-flex-opened font-change" :class="{ opened: opened.includes(officeUser.ID) }">
                            <div class="items-opened flex1" v-if="opened.includes(officeUser.ID)">
                                <img id="dash-symbol"
                                     :src="images.dash"
                                     @click="toggle(officeUser.ID)"
                                     alt="Less Information"/>
                            </div>
                            <div class="items-opened flex1" v-else>
                                <img id="plus-symbol"
                                     :src="images.plus"
                                     @click="toggle(officeUser.ID)"
                                     alt="More Information"/>
                            </div>
                            <div class="items-opened flex1 first-column">{{ officeUser.Version }}</div>
                            <div class="items-opened flex5">{{ officeUser.Key }}</div>
                            <div class="items-opened flex2">{{ moment(officeUser.AddedOn).format("MMM Do YYYY") }}</div>
                            <div class="items-opened flex4">{{ officeUser.email }}</div>
                            <div class="items-opened flex2">{{ officeUser.creator.UST_First_Name }}
                                {{ officeUser.creator.UST_Last_Name }}
                            </div>
                            <div class="items-opened flex1 pl-3">
                                <span class="pr-3">
                                    <img @click="editModal(officeUser)"
                                         id="pencil-symbol"
                                         :src="images.pencil"
                                         alt="Edit"
                                         data-toggle="modal"
                                         data-target="#edit-modal"/>
                                </span>
                                <span>
                                    <img @click="deleteModal(officeUser)"
                                         id="trash-symbol"
                                         :src="images.trash"
                                         alt="Delete"
                                         data-toggle="modal"
                                         data-target="#delete-modal"/>
                                </span>
                            </div>
                        </div>
                        <div class="table-flex-expanded" v-if="opened.includes(officeUser.ID)">
                            <div v-if="officeUser.password" class="items-expanded pb-4">Password
                                <span>{{ officeUser.password }}</span>
                            </div>
                            <div v-if="officeUser.PCName" class="items-expanded pb-4">PC Name
                                <span>{{ officeUser.PCName }}</span>
                            </div>
                            <div v-if="officeUser.UserName" class="items-expanded pb-4">Username
                                <span>{{ officeUser.UserName }}</span>
                            </div>
                            <div v-if="officeUser.updater.USR_Full_Name" class="items-expanded pb-4">Last Updated
                                By
                                <span>{{ officeUser.updater.USR_Full_Name }}</span>
                            </div>
                            <div v-if="officeUser.LastUpdatedOn" class="items-expanded pb-4">Last Updated On
                                <span>{{ moment(officeUser.LastUpdatedOn).format("MMM Do YYYY") }}</span>
                            </div>
                            <div v-if="officeUser.Notes" class="items-expanded">Notes
                                <span>{{ officeUser.Notes }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-auto main-table mb-3 pt-3 shadow text-center">
                        <b-pagination class="p-3"
                                      v-model="currentPage"
                                      :total-rows="rows"
                                      :per-page="perPage"
                                      first-text="First"
                                      prev-text="Prev"
                                      next-text="Next"
                                      last-text="Last"
                                      align="center"
                                      pills>
                        </b-pagination>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
import SearchBar from "./SearchBar";
import CreateModal from "./CreateModal";
import EditModal from "./EditModal";
import DeleteModal from "./DeleteModal";
import moment from "moment";


export default {
    components: {
        SearchBar,
        CreateModal,
        EditModal,
        DeleteModal
    },
    name: "officeUsersHome",
    data() {
        return {
            moment: moment,
            ITL_ID: '',
            search: {},
            showCreateModal: false,
            showEditModal: false,
            showDeleteModal: false,
            loading: false,
            opened: [],
            attributes: {
                officeUsers: {},
                searchableUserNames: [],
            },
            officeUserData: [{
                creator: {
                    USR_Full_Name: '',
                    UST_First_Name: '',
                    UST_Last_Name: ''
                },
                updater: {},
                deleter: {}
            }],
            selectedAttribute: {},
            images: {
                pencil: this.$sharedImages + '/edit.svg',
                plus: this.$sharedImages + '/plus1.svg',
                trash: this.$sharedImages + '/delete.svg',
                dash: this.$sharedImages + '/minus.svg',
            },
            currentPage: 1
        }
    },
    computed: {
        rows() {
            return this.attributes.officeUsers.total
        },
        perPage() {
            return this.attributes.officeUsers.per_page
        }
    },
    watch: {
        currentPage() {
            this.getAttributes();
        }
    },
    methods: {
        getAttributes() {
            let vm = this;
            this.loading = true;
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            axios
                .get(vm.$baseUrl + vm.$officeUsersUrl + '?page=' + vm.currentPage, {
                    params: {
                        email: vm.search.searchEmail,
                        UserName: vm.search.searchUserName
                    },
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.attributes = response.data;
                })
                .catch(error => {
                    vm.errorMessage();
                })
                .finally(() => {
                    vm.nullToEmptyString(vm.attributes.officeUsers.data);
                    vm.loading = false;
                    vm.currentPage = vm.attributes.officeUsers.current_page;
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
            this.officeUserData = object;
        },
        successMessage() {
            this.$swal({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: 'Success!'
            });
        },
        errorMessage() {
            this.$swal({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'error',
                title: 'Error!'
            });
        },
        toggle(id) {
            const index = this.opened.indexOf(id);
            if (index > -1) {
                this.opened.splice(index, 1);
            } else {
                this.opened.push(id);
            }
        },
        setSearchParams(searchedTerm) {
            this.search = searchedTerm;
            this.getAttributes();
        },
        resetSearchParams(clearSearchedTerm) {
            this.search = clearSearchedTerm;
            this.getAttributes();
        },
        createModal() {
            this.showCreateModal = true;
            this.showEditModal = false;
            this.showDeleteModal = false;
        },
        editModal(attribute) {
            this.showCreateModal = false;
            this.showEditModal = true;
            this.showDeleteModal = false;
            this.selectedAttribute = attribute
        },
        deleteModal(attribute) {
            this.showCreateModal = false;
            this.showEditModal = false;
            this.showDeleteModal = true;
            this.selectedAttribute = attribute
        },
        hideModals(e) {
            this.showCreateModal = e;
            this.showEditModal = e;
            this.showDeleteModal = e;
        }
    },
    mounted() {
        this.getAttributes();
    }
}
</script>
