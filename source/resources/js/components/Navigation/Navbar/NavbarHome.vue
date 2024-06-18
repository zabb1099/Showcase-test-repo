<template>
    <nav class="topNavbar">
        <div class="routeName">{{ $route.name }}</div>
        <img class="iconTopNavbar" :src="icon" alt="User Profile Icon"/>
        <div class="userInfoTopNavbar">{{ username }} ({{ userId }})</div>
    </nav>
</template>

<script>

export default {
    data() {
        return {
            username: '',
            userId: '',
            icon: this.$topNavBarImages + '/person-fill.svg',
        };
    },
    methods: {
        userInformation() {
            this.username = JSON.parse(localStorage.getItem('session')).USR_Full_Name;
            this.userId = JSON.parse(localStorage.getItem('session')).USR_ID;
        }
    },
    mounted() {
        this.userInformation();
    }
}

</script>
