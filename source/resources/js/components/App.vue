<template>
    <div class="bk-colour-grey">
        <router-view name="sidebar" @toggleSidebar="toggleSidebar"/>
        <router-view name="topNavbar"/>
        <router-view :class="[{ 'margin-left' : expanded }, 'margin-top']"/>
    </div>
</template>

<script>

    export default {
        name: 'App',
        data() {
            return {
                expanded: false
            }
        },
        methods: {
            toggleSidebar(value) {
                this.expanded = value;
            }
        }
    }

</script>

<style lang="scss" scoped>

    .margin-top {
        margin-top: 44px;
    }
    .margin-left {
        margin-left: 142px;
    }

</style>
