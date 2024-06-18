<template>
    <div id="loadingSpinner" class="pageSize">
        <fieldset :disabled="loading">
            <div class="loader" v-if="loading"></div>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">Issue Self-Study</h2>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
export default {
    name: "IssueSelfStudy",
    data() {
        return {
            loading: false
        }
    }
}
</script>


