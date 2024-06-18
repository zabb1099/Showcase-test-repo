<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">Company Docs</h2>
                    </div>
                    <div class="card-container">
                        <div @click="selectDocumentManager" class="orange-tile mt-5">
                            <h4 class="card-title">Document Manager</h4>
                        </div>
                        <div @click="selectTeamDocumentManager" class="green-tile">
                            <h4 class="card-title">Team Document Manager</h4>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
import DocumentManager from "./DocumentManager";
import TeamDocumentManager from "./TeamDocumentManager";

export default {
    name: "CompanyDocsHome",
    components: {
        DocumentManager,
        TeamDocumentManager
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        selectDocumentManager() {
            this.$router.push({
                path: this.$bwPortalView + this.$companyDocsView + '/document-manager'
            });
        },
        selectTeamDocumentManager() {
            this.$router.push({
                path: this.$bwPortalView + this.$companyDocsView + '/team-document-manager'
            });
        }
    }
}
</script>
