<template>
    <div>
        <ul class="subMenuTwo">
            <li v-for="link in links" :key="link.id" @click="selected = link.value" :class="{ selectedElement: selected.includes(link.value)}">
                <span>{{ link.name }}</span>
            </li>
        </ul>
        <ClientTypeHome v-if="selected ==='clientType'" :errorMessage="errorMessage"/>
        <ClientStatusHome v-if="selected ==='clientStatus'" :errorMessage="errorMessage"/>
        <DuplicateFileHome v-if="selected ==='duplicateFile'" />
    </div>
</template>

<script>
    import ClientTypeHome from "./FileType/ClientTypeHome";
    import ClientStatusHome from "./ClientStatus/ClientStatusHome";
    import DuplicateFileHome from "./DuplicateFile/DuplicateFileHome";

    export default {
        name: "DebtsolvFileHome",
        components: {
            ClientTypeHome,
            ClientStatusHome,
            DuplicateFileHome
        },
        data() {
            return {
                selected: 'clientStatus',
                links: [
                    {name: 'Client Status', value: 'clientStatus'},
                    {name: 'Client Type', value: 'clientType'},
                    {name: 'Delete Duplicate File', value: 'duplicateFile'}
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
