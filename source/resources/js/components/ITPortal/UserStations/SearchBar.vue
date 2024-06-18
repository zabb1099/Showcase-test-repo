<template>
    <div @keyup.enter="searchParameters()"
         class="main-table shadow header-font">

        <div class="search-header" v-if="showSearch === false">
            <div class="search-image search-padding">
                <img @click="toggleSearchOn"
                     id="plus-symbol"
                     :src="images.plus"
                     alt="More Information"/>
            </div>
            <div class="search-text search-padding">Search</div>
        </div>
        <div v-else class="pb-3">
            <div class="search-header">
                <div class="search-image search-padding">
                    <img @click="toggleSearchOff"
                         id="dash-symbol"
                         :src="images.dash"
                         alt="Less Information"/>
                </div>
                <div class="search-text search-padding">Search</div>
            </div>
            <div class="form-row">
                <label for="search-desk-name" class="col-sm-1 col-form-label">Desk Name</label>
                <div class="col-sm-5">
                    <input class="input-styling form-control"
                           id="search-desk-name"
                           type="search"
                           v-model="searchParams.searchDeskName">
                </div>
                <label for="search-OS" class="col-form-label OS-label">OS</label>
                <div class="col-sm-5">
                    <input class="input-styling form-control"
                           id="search-OS"
                           type="search"
                           v-model="searchParams.searchOS">
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
        attributes: Object,
        images: Object
    },
    data() {
        return {
            searchParams: {
                searchDeskName: '',
                searchOS: ''
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
            this.searchParams.searchDeskName = '';
            this.searchParams.searchOS = '';
            this.$emit('resetSearch', this.searchParams);
        }
    }
}

</script>
