<template>
    <div>
        <ul class="subMenuTwo">
            <li @click="toggle('clientFileLockedFSS')"
                :class="{ selectedElement: selected.includes('clientFileLockedFSS')}">
                <span>FSS</span>
            </li>
            <li @click="toggle('clientFileLockedDM')"
                :class="{ selectedElement: selected.includes('clientFileLockedDM')}">
                <span>DM Debtsolv</span>
            </li>
            <li @click="toggle('clientFileLockedIVA')"
                :class="{ selectedElement: selected.includes('clientFileLockedIVA')}">
                <span>IVA Debtsolv</span>
            </li>
        </ul>
        <ClientFileLockedFSS
            v-if="selected ==='clientFileLockedFSS'"
            :errorMessage="errorMessage"
            :successMessage="successMessage">
        </ClientFileLockedFSS>
        <ClientFileLockedDM
            v-if="selected ==='clientFileLockedDM'"
            :errorMessage="errorMessage"
            :successMessage="successMessage">
        </ClientFileLockedDM>
        <ClientFileLockedIVA
            v-if="selected ==='clientFileLockedIVA'"
            :errorMessage="errorMessage"
            :successMessage="successMessage">
        </ClientFileLockedIVA>
    </div>
</template>
<script>

import ClientFileLockedFSS from "./ClientFileLockedFSS";
import ClientFileLockedDM from "./ClientFileLockedDM";
import ClientFileLockedIVA from "./ClientFileLockedIVA";

export default {
    name: "ClientFileLockedHome",
    components: {
        ClientFileLockedIVA,
        ClientFileLockedDM,
        ClientFileLockedFSS
    },
    data() {
        return {
            selected: 'clientFileLockedFSS'
        }
    },
    methods: {
        toggle(value) {
            if (value === 'clientFileLockedFSS') {
                this.selected = 'clientFileLockedFSS'
            }

            if (value === 'clientFileLockedDM') {
                this.selected = 'clientFileLockedDM'
            }

            if (value === 'clientFileLockedIVA') {
                this.selected = 'clientFileLockedIVA'
            }
        },
        successMessage() {
            this.$swal.fire({
                icon: 'success',
                title: 'Lock cleared!'
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

