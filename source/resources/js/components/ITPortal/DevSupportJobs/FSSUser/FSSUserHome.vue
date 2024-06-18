<template>
    <div>
        <ul class="subMenuTwo">
            <li v-for="link in links" :key="link.id" @click="selected = link.value" :class="{ selectedElement: selected.includes(link.value)}">
                <span>{{ link.name }}</span>
            </li>
        </ul>
        <UpdateBFGPortalLogin v-if="selected ==='updateBFGPortalLogin'" :errorMessage="errorMessage" />
    </div>
</template>

<script>
   import UpdateBFGPortalLogin from "./UpdateBFGPortalLogin";

    export default {
        name: "FSSUserHome",
        components: {
            UpdateBFGPortalLogin
        },
        data() {
            return {
                selected: 'updateBFGPortalLogin',
                links: [
                    {name: 'Update User', value: 'updateBFGPortalLogin'},
                ]
            }
        },
        methods: {
            errorMessage() {
                this.$swal({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000,
                    icon: 'error',
                    title: 'Error!'
                });
            }
        }
    }
</script>

