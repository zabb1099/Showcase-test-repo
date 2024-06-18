<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>

                <create-modal
                    @hideCreateModal= "createModal"
                />

                <update-modal
                    :selectedAttribute="selectedAttribute"
                    />
                <delete-modal
                    :selectedAttribute="selectedAttribute"
                    />


            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">NoticeBoard</h2>
                    </div>

                    <div class="mb-4 clearfix">
                        <button
                            @click="createModal"
                            class="float-right green-btn"
                            data-toggle="modal"
                            data-target="#create-modal"
                        >
                            Add new
                        </button>
                    </div>

                    <div class="table-flex-header main-table mb-3 shadow header-font">
                        <div class="items-header flex1"></div>
                        <div class="items-header flex1">Header</div>
                        <div class="items-header flex5">Details</div>
                        <div class="items-header flex2">Priority Level</div>
                        <div class="items-header flex4">Created At</div>
                        <div class="items-header flex2">Created By</div>
                        <div class="items-header flex1"></div>
                    </div>

                    <div class="table-flex-opened shadow main-table" v-for="itNotices in itNoticeData" :key="itNotices.id">

                        <div class ="flex1 items-opened first-column">{{itNotices.id}}</div>
                        <div class ="flex1 items-opened">{{itNotices.notice_header}}</div>
                        <div class ="flex5 items-opened">{{itNotices.notice_body}}</div>
                        <div class ="flex2 items-opened">{{itNotices.priority_level}}</div>
                        <div class ="flex4 items-opened">{{itNotices.created_at}}</div>
                        <div class ="flex2 items-opened">{{itNotices.created_by !=null ? itNotices.created_by.USR_Full_Name: "N/A"}}</div>
                        <div class ="flex1 items-opened">
                        <span class="pr-3">
                            <img @click="updateModal(itNotices)"
                                    id="pencil-symbol"
                                         :src="images.pencil"
                                         alt="Edit"
                                data-toggle="modal"
                                data-target="#update-modal"
                            />
                        </span>
                            <span>
                                    <img @click="deleteModal(itNotices)"
                                         id="trash-symbol"
                                         :src="images.trash"
                                         alt="Edit"
                                         data-toggle="modal"
                                         data-target="#delete-modal"
                                    />
                                </span>
                        </div>
                    </div>



<!--                    <div class="overflow-auto main-table mb-3 pt-3 shadow text-center">-->
<!--                        <b-pagination class="p-3"-->
<!--                                      v-model="currentPage"-->
<!--                                      :total-rows="rows"-->
<!--                                      :per-page="perPage"-->
<!--                                      first-text="First"-->
<!--                                      prev-text="Prev"-->
<!--                                      next-text="Next"-->
<!--                                      last-text="Last"-->
<!--                                      align="center"-->
<!--                                      pills>-->
<!--                        </b-pagination>-->
<!--                    </div>-->

                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>

    import CreateModal from "./CreateModal";
    import UpdateModal from "./EditModal";
    import DeleteModal from "./DeleteModal";

    export default {
        components: {
            CreateModal,
            UpdateModal,
            DeleteModal
        },
        name: "itNotices",

        data() {
            return {
                loading: false,
                attributes: {
                    itNotices: {},
                },
                itNoticeData: [],
                showCreateModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                selectedAttribute: {},
                 images: {
                     pencil: this.$sharedImages + '/edit.svg',
                     trash: this.$sharedImages + '/delete.svg'
                 }
            }
        },

        computed: {
            rows() {
                return this.attributes.itNotices.total
            },
            perPage() {
                return this.attributes.itNotices.per_page
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
                    .get(vm.$baseUrl + vm.$noticeBoardUrl, {

                        headers: {
                            "Authorization": `Bearer ${bearerToken}`
                        }
                })
                    .then(response => {
                        vm.attributes = response.data
                        vm.notices = vm.attributes.itNotices
                        })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                        vm.loading = false;
                        vm.itNoticeData= vm.notices
                    })

            },
            createModal() {
                this.showCreateModal = !this.showCreateModal;
            },

            updateModal(itNotice) {
                this.selectedAttribute = itNotice;
                this.showUpdateModal = !this.showUpdateModal;
            },

            deleteModal(itNotice) {
                this.showDeleteModal = !this.showDeleteModal;
                this.selectedAttribute = itNotice;
            }

        },


        created() {
            this.getAttributes();
        }
    }
</script>
