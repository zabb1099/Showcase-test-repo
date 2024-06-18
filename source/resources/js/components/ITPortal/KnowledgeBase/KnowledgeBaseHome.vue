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
                        <div class="items-header flex5">Short Name</div>
                        <div class="items-header flex4">Issue Type</div>
                        <div class="items-header flex3">Date Created</div>
                        <div class="items-header flex3">Created By</div>
                        <div class="items-header flex3">Team Name</div>
                        <div class="items-header flex2"></div>
                    </div>

                    <div class="shadow main-table" v-for="knowledgeBase in knowledgeBaseData"
                         :key="knowledgeBase.ITL_ID">
                        <div class="table-flex-opened font-change"
                             :class="{ opened: opened.includes(knowledgeBase.ITL_ID) }">
                            <div class="items-opened flex1" v-if="opened.includes(knowledgeBase.ITL_ID)">
                                <img id="dash-symbol"
                                     :src="images.dash"
                                     @click="toggle(knowledgeBase.ITL_ID)"
                                     alt="Less Information"/>
                            </div>
                            <div class="items-opened flex1" v-else>
                                <img id="plus-symbol"
                                     :src="images.plus"
                                     @click="toggle(knowledgeBase.ITL_ID)"
                                     alt="More Information"/>
                            </div>
                            <div class="items-opened flex5 first-column">{{ knowledgeBase.Short_Name }}</div>
                            <div class="items-opened flex4">{{ knowledgeBase.Issue_Type }}</div>
                            <div class="items-opened flex3">
                                {{ moment(knowledgeBase.Date_Created).format("MMM Do YYYY") }}
                            </div>
                            <div class="items-opened flex3">{{ knowledgeBase.creator.USR_Full_Name }}</div>
                            <div class="items-opened flex3">{{ knowledgeBase.team_names.TEAM_Name }}</div>
                            <div class="items-opened flex2 pl-3">
                                <span class="pr-3">
                                    <img @click="editModal(knowledgeBase)"
                                         id="pencil-symbol"
                                         :src="images.pencil"
                                         alt="Edit"
                                         data-toggle="modal"
                                         data-target="#edit-modal"/>
                                </span>
                                <span>
                                    <img @click="deleteModal(knowledgeBase)"
                                         id="trash-symbol"
                                         :src="images.trash"
                                         alt="Delete"
                                         data-toggle="modal"
                                         data-target="#delete-modal"/>
                                </span>
                            </div>
                        </div>
                        <div class="table-flex-expanded" v-if="opened.includes(knowledgeBase.ITL_ID)">
                            <div v-if="knowledgeBase.it_projects.Project_Name" class="items-expanded pb-4">Project Name
                                <span>{{ knowledgeBase.it_projects.Project_Name }}</span>
                            </div>
                            <div v-if="knowledgeBase.it_projects.Project_Link" class="items-expanded pb-4">Project Link
                                <span><a class="link-text" :href="knowledgeBase.it_projects.Project_Link">
                                    {{ knowledgeBase.it_projects.Project_Link }}</a></span>
                            </div>
                            <div v-if="knowledgeBase.Issue_Description" class="items-expanded-full-width pb-4 mb-4">
                                Issue Description
                                <b-form-textarea
                                    class="knowledgeBaseDescription"
                                    rows="0"
                                    max-rows="1000"
                                    cols="200"
                                    v-model="knowledgeBase.Issue_Description"
                                    readonly
                                ></b-form-textarea>
                            </div>
                            <div v-if="knowledgeBase.Solution_Description" class="items-expanded-full-width">
                                Solution Description
                                <b-form-textarea
                                    class="knowledgeBaseDescription"
                                    rows="3"
                                    max-rows="1000"
                                    cols="200"
                                    v-model="knowledgeBase.Solution_Description"
                                    readonly
                                ></b-form-textarea>
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
                                      pills
                        ></b-pagination>
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
    name: "KnowledgeBase",
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
                itProjects: [],
                knowledgeBase: {},
                searchableItProjects: [],
                searchableTeamNames: [],
                searchableUserNames: [],
                teamNames: []
            },
            knowledgeBaseData: [],
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
            return this.attributes.knowledgeBase.total
        },
        perPage() {
            return this.attributes.knowledgeBase.per_page
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
                .get(vm.$baseUrl + vm.$knowledgeBaseUrl + '?page=' + vm.currentPage, {
                    params: {
                        Short_Name: vm.search.searchShortIssue,
                        Issue_Type: vm.search.searchIssueType,
                        ITP_ID: vm.search.searchProjectName,
                        TEAM_ID: vm.search.searchTeamName,
                        Created_By: vm.search.searchCreatedBy
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
                    vm.nullToEmptyString(vm.attributes.knowledgeBase.data);
                    vm.loading = false;
                    vm.currentPage = vm.attributes.knowledgeBase.current_page;
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
            this.knowledgeBaseData = object;
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
