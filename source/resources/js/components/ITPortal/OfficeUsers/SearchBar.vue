<template>
    <div @keyup.enter="searchParameters(); toggleSearchOff()"
         class="main-table shadow header-font">

        <div class="search-header" v-if="showSearch === false">
            <div class="search-image search-padding">
                <img id="plus-symbol"
                     :src="images.plus"
                     @click="toggleSearchOn"
                     alt="More Information"/>
            </div>
            <div class="search-text search-padding">Search</div>
        </div>
        <div v-else class="pb-3">
            <div class="search-header">
                <div class="search-image search-padding">
                    <img id="dash-symbol"
                         :src="images.dash"
                         @click="toggleSearchOff"
                         alt="Less Information"/>
                </div>
                <div class="search-text search-padding">Search</div>
            </div>
            <div class="form-row">
                <label for="search-email" class="col-sm-1 col-form-label">Email</label>
                <div class="col-sm-5">
                    <input class="input-styling form-control"
                           id="search-email"
                           type="search"
                           v-model="searchParams.searchEmail">
                </div>
                <label for="search-username" class="col-sm-1 col-form-label">Username</label>
                <div class="col-sm-5">
                    <input class="input-styling form-control"
                           id="search-username"
                           type="search"
                           v-model="searchParams.searchUserName">
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12">
                    <button @click="searchParameters(); toggleSearchOff()"
                            class="search-btn-full-width blue-btn float-right"
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
        getAttributes: Object,
        images: Object
    },
    data() {
        return {
            searchParams: {
                searchEmail: '',
                searchUserName: ''
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
            this.searchParams.searchEmail = '';
            this.searchParams.searchUserName = '';
            this.$emit('resetSearch', this.searchParams);
        }
    }
}

</script>
