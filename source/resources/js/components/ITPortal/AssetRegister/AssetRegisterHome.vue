<template>
    <div class="loadingSpinner pageSize">
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
                            :placeholder="'Search...'"
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
                        <div class="items-header flex3">Name</div>
                        <div class="items-header flex3">Asset Type</div>
                        <div class="items-header flex3">Model</div>
                        <div class="items-header flex3">Serial No</div>
                        <div class="items-header flex3">Date Added</div>
                        <div class="items-header flex1"></div>
                    </div>

                    <div class="shadow main-table" v-for="assetRegister in assetRegisterData" :key="assetRegister.ID">
                        <div class="table-flex-opened font-change"
                             :class="{ opened: opened.includes(assetRegister.ID) }">
                            <div class="items-opened flex1" v-if="opened.includes(assetRegister.ID)">
                                <img id="dash-symbol"
                                     :src="images.dash"
                                     @click="toggle(assetRegister.ID)"
                                     alt="Less Information"/>
                            </div>
                            <div class="items-opened flex1" v-else>
                                <img id="plus-symbol"
                                     :src="images.plus"
                                     @click="toggle(assetRegister.ID)"
                                     alt="More Information"/>
                            </div>
                            <div class="items-opened flex3 first-column">{{ assetRegister.Name }}</div>
                            <div class="items-opened flex3">{{ assetRegister.Asset_Type }}</div>
                            <div class="items-opened flex3">{{ assetRegister.Model }}</div>
                            <div class="items-opened flex3">{{ assetRegister.Serial_No }}</div>
                            <div class="items-opened flex3">
                                {{ moment(assetRegister.Date_Added).format("MMM Do YYYY") }}
                            </div>
                            <div class="items-opened flex1 pl-3">
                                <span class="pr-3">
                                    <img @click="editModal(assetRegister)"
                                         id="pencil-symbol"
                                         :src="images.pencil"
                                         alt="Edit"
                                         data-toggle="modal"
                                         data-target="#edit-modal"/>
                                </span>
                                <span>
                                    <img @click="deleteModal(assetRegister)"
                                         id="trash-symbol"
                                         :src="images.trash"
                                         alt="Delete"
                                         data-toggle="modal"
                                         data-target="#delete-modal"/>
                                </span>
                            </div>
                        </div>
                        <div class="table-flex-expanded" v-if="opened.includes(assetRegister.ID)">
                            <div v-if="assetRegister.ZeroTier_IP_LPT" class="items-expanded pb-4">Zero Tier IP LPT
                                <span>{{ assetRegister.ZeroTier_IP_LPT }}</span>
                            </div>
                            <div v-if="assetRegister.Zero_Tier_IP_PC" class="items-expanded pb-4">Zero Tier IP PC
                                <span>{{ assetRegister.Zero_Tier_IP_PC }}</span>
                            </div>
                            <div v-if="assetRegister.Last_Updated_On" class="items-expanded pb-4">Last Updated
                                <span>{{ moment(assetRegister.Last_Updated_On).format("MMM Do YYYY") }}</span>
                            </div>
                            <div v-if="assetRegister.updater.USR_Full_Name" class="items-expanded pb-4">Updated By
                                <span>{{ assetRegister.updater.USR_Full_Name }}</span>
                            </div>
                            <div v-if="assetRegister.EmployeeName" class="items-expanded pb-4">Employee Name
                                <span>{{ assetRegister.EmployeeName }}</span>
                            </div>
                            <div v-if="assetRegister.LP_username" class="items-expanded pb-4">Username
                                <span>{{ assetRegister.LP_username }}</span>
                            </div>
                            <div v-if="assetRegister.LP_password" class="items-expanded pb-4">Password
                                <span>{{ assetRegister.LP_password }}</span>
                            </div>
                            <div v-if="assetRegister.Date_Given" class="items-expanded pb-4">Handover Date
                                <span>{{ moment(assetRegister.Date_Given).format("MMM Do YYYY") }}</span>
                            </div>
                            <div class="items-expanded">Signable
                                <span>Signable Link</span>
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
    name: "AssetRegisterHome",
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
                assetRegister: {},
                searchableUserNames: [],
            },
            assetRegisterData: [{
                updater: {
                    USR_Full_Name: '',
                    UST_First_Name: '',
                    UST_Last_Name: ''
                },
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
            return this.attributes.assetRegister.total
        },
        perPage() {
            return this.attributes.assetRegister.per_page
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
                .get(vm.$baseUrl + vm.$assetRegisterUrl + '?page=' + vm.currentPage + '&search=' + vm.search, {
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
                    vm.nullToEmptyString(vm.attributes.assetRegister.data);
                    vm.loading = false;
                    vm.currentPage = vm.attributes.assetRegister.current_page;
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
            this.assetRegisterData = object;
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
