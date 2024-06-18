<template>
    <div @keyup.enter="searchParameters(); toggleSearchOff()" class="main-table shadow header-font">
        <div v-if="!showSearch" class="search-header">
            <div class="search-image search-padding">
                <img @click="toggleSearchOn()" id="plus-symbol" :src="images.plus" alt="More Information"/>
            </div>
            <div class="search-text search-padding">Search</div>
        </div>
        <div v-else class="pb-3">
            <div class="search-header">
                <div class="search-image search-padding">
                    <img @click="toggleSearchOff()" id="dash-symbol" :src="images.dash" alt="Less Information"/>
                </div>
                <div class="search-text search-padding">Search</div>
            </div>
            <div class="form-row">
                <label for="search-short-name" class="col-sm-1 col-form-label">Short Name</label>
                <div class="col-sm-5">
                    <input class="input-styling form-control"
                           id="search-short-name"
                           type="search"
                           v-model="searchParams.searchShortIssue">
                </div>
                <label for="search-issue-type" class="col-sm-1 col-form-label">Issue Type</label>
                <div class="col-sm-5">
                    <input class="input-styling form-control"
                           id="search-issue-type"
                           type="search"
                           v-model="searchParams.searchIssueType">
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-1 col-form-label">Team Name</label>
                <div class="col-sm-5">
                    <select class="input-styling form-control" id="search-team-name"
                            v-model="searchParams.searchTeamName">
                        <option class="select-background" selected value="">-- Please Select Team --</option>
                        <option class="select-background" v-for="team in attributes.searchableTeamNames"
                                :value="team.TEAM_ID">
                            {{ team.TEAM_Name }}
                        </option>
                    </select>
                </div>
                <label class="col-sm-1 col-form-label">Project</label>
                <div class="col-sm-5">
                    <select class="input-styling form-control" id="search-project"
                            v-model="searchParams.searchProjectName">
                        <option selected value="">-- Please Select Project --</option>
                        <option v-for="project in attributes.searchableItProjects" :value="project.ITP_ID">
                            {{ project.Project_Name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-1 col-form-label">Created By</label>
                <div class="col-sm-5">
                    <select class="input-styling form-control" id="search-created-by"
                            v-model="searchParams.searchCreatedBy">
                        <option selected value="">-- Please Select Team Member --</option>
                        <option v-for="user in attributes.searchableUserNames" :value="user.USR_ID">
                            {{ user.USR_Full_Name }}
                        </option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <button @click="searchParameters(); toggleSearchOff()"
                            class="search-btn blue-btn float-right"
                            :disabled="isLoading">
                        {{ isLoading ? "Searching..." : "Search" }}
                    </button>
                    <button @click="resetSearch()" class="reset-btn purple-btn float-right">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "SearchBar",
    props: {
        attributes: Object,
        images: Object
    },
    data() {
        return {
            searchParams: {
                searchShortIssue: '',
                searchIssueType: '',
                searchTeamName: '',
                searchProjectName: '',
                searchCreatedBy: '',
            },
            isLoading: false,
            showSearch: false
        }
    },
    methods: {
        searchParameters() {
            this.$emit('setSearch', this.searchParams);
        },
        toggleSearchOn() {
            this.showSearch = true
        },
        toggleSearchOff() {
            this.showSearch = false
        },
        resetSearch() {
            this.searchParams.searchShortIssue = '';
            this.searchParams.searchIssueType = '';
            this.searchParams.searchTeamName = '';
            this.searchParams.searchProjectName = '';
            this.searchParams.searchCreatedBy = '';
            this.$emit('resetSearch', this.searchParams);
        }
    }
}

</script>
