<template>
    <div>
        <ul>
            <li class="sideBarMiddleElements" :class="[ activeFirst ? 'iconSideBarOnFirst' : 'iconSideBarOffFirst' ]"
                @click="sidebarFirstElement">
                <img v-show="!activeFirst" class="iconSideBar" :src="images.knowledgeBaseOff"
                     alt="White Knowledge Base Icon"/>
                <img v-show="activeFirst" class="iconSideBar" :src="images.knowledgeBaseOn"
                     alt="Purple Knowledge Base Icon"/>
                <p :class="[ activeFirst ? 'sideBarTextOn' : 'sideBarTextOff' ]" v-show="active">QA PORTAL 1</p>
            </li>
            <li class="sideBarMiddleElements" :class="[ activeSecond ? 'iconSideBarOnSecond' : 'iconSideBarOffSecond' ]"
                @click="sidebarSecondElement">
                <img v-show="!activeSecond" class="iconSideBar" :src="images.officeUsersOff"
                     alt="White Office Users Icon"/>
                <img v-show="activeSecond" class="iconSideBar" :src="images.officeUsersOn"
                     alt="Purple Office Users Icon"/>
                <p :class="[ activeSecond ? 'sideBarTextOn' : 'sideBarTextOff' ]" v-show="active">QA PORTAL 2</p>
            </li>
            <li class="sideBarMiddleElements" :class="[ activeThird ? 'iconSideBarOnThird' : 'iconSideBarOffThird' ]"
                @click="sidebarThirdElement">
                <img v-show="!activeThird" class="iconSideBar" :src="images.userStationOff"
                     alt="White User Station Icon"/>
                <img v-show="activeThird" class="iconSideBar" :src="images.userStationOn"
                     alt="Purple User Station Icon"/>
                <p :class="[ activeThird ? 'sideBarTextOn' : 'sideBarTextOff' ]" v-show="active">QA PORTAL 3</p>
            </li>
            <li class="sideBarMiddleElements" :class="[ activeFourth ? 'iconSideBarOnFourth' : 'iconSideBarOffFourth' ]"
                @click="sidebarFourthElement">
                <img v-show="!activeFourth" class="iconSideBar" :src="images.assetsRegisterOff"
                     alt="White Pencil Square Icon"/>
                <img v-show="activeFourth" class="iconSideBar" :src="images.assetsRegisterOn"
                     alt="Purple Pencil Square Icon"/>
                <p :class="[ activeFourth ? 'sideBarTextOn' : 'sideBarTextOff' ]" v-show="active">QA PORTAL 4</p>
            </li>
            <li id="sideBarLastElement" :class="[ activeLast ? 'iconSideBarOnLast' : 'iconSideBarOffLast' ]"
                @click="sidebarLastElement">
                <img v-show="!activeLast" class="iconSideBar" :src="images.logoutOff" alt="White Box Right Arrow Icon"/>
                <img v-show="activeLast" class="iconSideBar" :src="images.logoutOn" alt="Purple Box Right Arrow Icon"/>
                <p :class="[ activeLast ? 'sideBarTextOn' : 'sideBarTextOff' ]" v-show="active">Log Out</p>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        active: Boolean,
    },
    data() {
        return {
            images: {
                userStationOff: this.$sideBarImages + '/user-stations_off.svg',
                userStationOn: this.$sideBarImages + '/user-stations_on.svg',
                logoutOff: this.$sideBarImages + '/log-out_off.svg',
                logoutOn: this.$sideBarImages + '/log-out_on.svg',
                assetsRegisterOff: this.$sideBarImages + '/asset-register_off.svg',
                assetsRegisterOn: this.$sideBarImages + '/asset-register_on.svg',
                officeUsersOff: this.$sideBarImages + '/office-users_off.svg',
                officeUsersOn: this.$sideBarImages + '/office-users_on.svg',
                knowledgeBaseOff: this.$sideBarImages + '/knowledge-base_off.svg',
                knowledgeBaseOn: this.$sideBarImages + '/knowledge-base_on.svg',
            },
            activeFirst: false,
            activeSecond: false,
            activeThird: false,
            activeFourth: false,
            activeLast: false,
        }
    },
    methods: {
        sidebarFirstElement() {
            this.activeFirst = !this.activeFirst;
            this.activeSecond === true && (this.activeSecond = !this.activeSecond);
            this.activeThird === true && (this.activeThird = !this.activeThird);
            this.activeFourth === true && (this.activeFourth = !this.activeFourth);
            this.activeLast === true && (this.activeLast = !this.activeLast);
            this.$emit('displayContentITPortal', {
                show: 'knowledge-base'
            })
        },
        sidebarSecondElement() {
            this.activeFirst === true && (this.activeFirst = !this.activeFirst);
            this.activeSecond = !this.activeSecond;
            this.activeThird === true && (this.activeThird = !this.activeThird);
            this.activeFourth === true && (this.activeFourth = !this.activeFourth);
            this.activeLast === true && (this.activeLast = !this.activeLast);
            this.$emit('displayContentITPortal', {
                show: 'office-users'
            })
        },
        sidebarThirdElement() {
            this.activeFirst === true && (this.activeFirst = !this.activeFirst);
            this.activeSecond === true && (this.activeSecond = !this.activeSecond);
            this.activeThird = !this.activeThird;
            this.activeFourth === true && (this.activeFourth = !this.activeFourth);
            this.activeLast === true && (this.activeLast = !this.activeLast);
            this.$emit('displayContentITPortal', {
                show: 'user-station'
            })
        },
        sidebarFourthElement() {
            this.activeFirst === true && (this.activeFirst = !this.activeFirst);
            this.activeSecond === true && (this.activeSecond = !this.activeSecond);
            this.activeThird === true && (this.activeThird = !this.activeThird);
            this.activeFourth = !this.activeFourth;
            this.activeLast === true && (this.activeLast = !this.activeLast);
            this.$emit('displayContentITPortal', {
                show: 'asset-register'
            })
        },
        sidebarLastElement() {
            this.activeFirst === true && (this.activeFirst = !this.activeFirst);
            this.activeThird === true && (this.activeThird = !this.activeThird);
            this.activeFourth === true && (this.activeFourth = !this.activeFourth);
            this.activeSecond === true && (this.activeSecond = !this.activeSecond);
            this.activeLast = !this.activeLast;
        },
    }
}

</script>
