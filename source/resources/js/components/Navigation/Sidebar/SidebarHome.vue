<template>
    <nav :class="[ expandSidebar ? 'sidebar expandSidebar' : 'sidebar' ]">
        <ul class="sidebarElements">
            <li @click="toggleSidebar">
                <img v-show="!expandSidebar" id="iconSideBarArrowRight" :src="menu" alt="Menu Icon"/>
                <img v-show="expandSidebar" id="iconSideBarLogo" :src="logo" alt="Logo Icon"/>
            </li>

            <li v-for="item in items" :key="item.id" @click="selectItem(item.id)"
                :class="[ item.name === 'Logout' ? 'line' : '', { activeElement: item.active }, 'menuItems' ]"
                @mouseover="item.iconActive = true" @mouseleave="item.iconActive = false">
                <img v-if="item.active || item.iconActive" :src="item.iconOn" alt="Icon"/>
                <img v-else :src="item.iconOff" alt="Icon"/>
                <p v-show="expandSidebar">{{ item.name }}</p>
            </li>
        </ul>
    </nav>
</template>

<script>

    export default {
        name: "SidebarHome",
        data() {
            return {
                expandSidebar: false,
                logo: '/images/SideBar/logo.svg',
                menu: '/images/SideBar/menu.svg',
                items: [
                    {
                        id: 1,
                        name: 'Dev Support',
                        active: false,
                        iconActive: false,
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
            toggleSidebar() {
                this.expandSidebar = !this.expandSidebar;
                this.$emit('toggleSidebar', this.expandSidebar);
            },
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
        },
        mounted() {
            this.items.forEach(item => {
                if (item.path == this.$route.path) this.selectItem(item.id);
            });
        }
    }

</script>
