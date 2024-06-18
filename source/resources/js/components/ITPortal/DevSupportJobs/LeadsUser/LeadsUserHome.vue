<template>
    <div>
        <ul class="subMenuTwo">
            <li v-for="link in links" :key="link.id" @click="selected = link.value" :class="{ selectedElement: selected.includes(link.value)}">
                <span>{{ link.name }}</span>
            </li>
        </ul>
        <LeadDispositions v-if="selected ==='leadsDispositions'" :errorMessage="errorMessage" />
        <CreatePhoenixLogin v-if="selected ==='createPhoenixLogin'" :errorMessage="errorMessage" />
        <LeadsTestCase v-if="selected ==='leadsTestCase'" :errorMessage="errorMessage" />
    </div>
</template>

<script>
    import CreatePhoenixLogin from "./CreatePhoenixLogin";
    import LeadDispositions from "./LeadDispositions";
    import LeadsTestCase from "./LeadsTestCase";

    export default {
        name: "LeadsUserHome",
        components: {
            CreatePhoenixLogin,
            LeadDispositions,
            LeadsTestCase
        },
        data() {
            return {
                selected: 'leadsDispositions',
                links: [
                    {name: 'Lead Dispositions', value: 'leadsDispositions'},
                    {name: 'Phoenix Login', value: 'createPhoenixLogin'},
                    {name: 'Update Test File', value: 'leadsTestCase'}
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
