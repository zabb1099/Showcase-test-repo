<template>
    <li v-for="item in items" :key="item.id" @click="selectItem(item.id)" :class="{ activeElement: item.active }"
        @mouseover="item.iconActive = true" @mouseleave="item.iconActive = false">
        <img v-if="item.active || item.iconActive" :src="item.iconOn" alt="Icon"/>
        <img v-else :src="item.iconOff" alt="Icon"/>
        <p v-show="expandSideBar">{{ item.name }}</p>
    </li>
</template>

<script>

    export default {
        props: {
            expandSideBar: Boolean
        },
        data() {
            return {
                items: [
                    {
                        id: 1,
                        name: 'Dev Support Jobs',
                        active: true,
                        iconActive: true,
                        iconOn: this.$devSupportJobsImgOn,
                        iconOff: this.$devSupportJobsImgOff,
                        path: this.$itPortalView + this.$devSupportJobsView
                    },
                    {
                        id: 2,
                        name: 'Print Queues',
                        active: false,
                        iconActive: false,
                        iconOn: this.$printQueuesImgOn,
                        iconOff: this.$printQueuesImgOff,
                        path: this.$itPortalView + this.$printQueuesView
                    },
                    {
                        id: 3,
                        name: 'Logout',
                        active: false,
                        iconActive: false,
                        iconOn: this.$logoutImgOn,
                        iconOff: this.$logoutImgOff,
                        path: this.$login
                    }
                ]
            }
        },
        methods: {
            selectItem(id) {
                this.items.forEach(item => {
                    let isMatch = item.id == id;
                    isMatch ? item.active = true : item.active = false;
                    isMatch ? item.iconActive = true : item.iconActive = false;

                    if (isMatch) this.$router.push({ path: item.path });

                    if (isMatch && item.name == 'Logout') {
                        axios.get('/logout', {
                            headers: {"Authorization": `Bearer ${this.$session.bearer_token}`}
                        }).then(response => {
                            localStorage.removeItem('session');
                            window.location.reload();
                        });
                    }
                });
            }
        }
    }

</script>
