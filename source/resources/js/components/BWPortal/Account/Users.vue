<template>
    <div class="pageSize">
        <fieldset>
            <div class="bk-colour-grey">
                <div class="col-md-12">
                    <div class="main card my-4 shadow">
                        <h2 class="py-3 main-header">Users</h2>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
export default {
    name: "Users",
    data() {
        return {
            users: []
        }
    },
    methods: {
        getUsers() {
            axios
                .get(this.$baseApiBWPortalView + this.$accountView + '/users')
                .then(response => {
                    this.users = response.data;
                });
        }

    },
    mounted() {
        this.getUsers();
    }
}
</script>
