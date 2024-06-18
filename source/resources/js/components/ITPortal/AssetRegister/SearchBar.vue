<template>
    <div @keyup.enter="searchParameters()" class="main-table shadow header-font">
        <div class="form-row asset-register-padding">
            <label for="search-asset-register" class="col-sm-1 col-form-label">Search</label>
            <div class="col-sm-5">
                <input
                    id="search-asset-register"
                    class="input-styling form-control"
                    type="search"
                    :placeholder="placeholder"
                    v-model="searchParams">
            </div>
            <div class="col-sm-6">
                <button @click="searchParameters()"
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
</template>

<script>

export default {
    name: "SearchBar",
    props: {
        attributes: Object,
        images: Object,
        placeholder: String
    },
    data() {
        return {
            searchParams: '',
            isLoading: false
        }
    },
    methods: {
        searchParameters() {
            this.$emit('setSearch', this.searchParams);
        },
        resetSearch() {
            this.searchParams = '';
            this.$emit('resetSearch', this.searchParams);
        }
    }
}

</script>
