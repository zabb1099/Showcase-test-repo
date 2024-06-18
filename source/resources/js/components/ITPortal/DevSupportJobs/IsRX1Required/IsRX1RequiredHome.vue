<template>
    <div>
        <ul class="subMenuTwo">
            <li @click="toggle('isRX1Required')"
                :class="{ selectedElement: selected.includes('isRX1Required')}">
                <span>RX1/Sale of Property</span>
            </li>
        </ul>
        <IsRX1Required
            v-if="selected ==='isRX1Required'"
            :errorMessage="errorMessage">
        </IsRX1Required>
    </div>
</template>
<script>
import IsRX1Required from "./IsRX1Required";

export default {
    name: "IsRX1RequiredHome",
    components: {
        IsRX1Required
    },
    data() {
        return {
            selected: 'isRX1Required'
        }
    },
    methods: {
        toggle(value) {
            if (value === 'isRX1Required') {
                this.selected = 'isRX1Required'
            }
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
