<template>
    <fieldset class="pageSize">
        <div class="mt-3">
            <div class="card shadow py-3 mb-3">
                <div class="col-2 form-flex-item-job no-border-bottom">
                    <select class="form-field" v-model="selected">
                        <option selected disabled value="placeholder">Please select a Debtsolv version...</option>
                        <option value="DM">DM</option>
                        <option value="IVA">IVA</option>
                    </select>
                </div>
            </div>
        </div>
        <BulkCreditorDM v-if="selected ==='DM'" :errorMessage="errorMessage"/>
        <BulkCreditorIVA v-if="selected ==='IVA'" :errorMessage="errorMessage"/>
    </fieldset>
</template>

<script>
    import BulkCreditorDM from "./DM/BulkCreditorDM";
    import BulkCreditorIVA from "./IVA/BulkCreditorIVA";

    export default {
        name: "BulkCreditorHome",
        components: {
            BulkCreditorDM,
            BulkCreditorIVA
        },
        data() {
            return {
                selected: 'placeholder'
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
