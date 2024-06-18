<template>
    <div>
        <ul class="subMenuTwo">
            <li @click="toggle('generateXML')"
                :class="{ selectedElement: selected.includes('generateXML')}">
                <span>XML Generation</span>
            </li>
        </ul>
        <XMLGeneration
            v-if="selected ==='generateXML'"
            :errorMessage="errorMessage"
            :successMessage="successMessage">
        </XMLGeneration>
    </div>
</template>
<script>

import XMLGeneration from "./XMLGeneration";

export default {
    name: "XMLGenerationHome",
    components: {
        XMLGeneration
    },
    data() {
        return {
            selected: 'generateXML'
        }
    },
    methods: {
        toggle(value) {
            if (value === 'generateXML') {
                this.selected = 'generateXML'
            }
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'XML Generated!'
            });
        },
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
