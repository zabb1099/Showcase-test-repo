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
        <DMCreditorBACS v-if="selected ==='DM'" :errorMessage="errorMessage" :successMessage="successMessage"/>
        <IVACreditorBACS v-if="selected ==='IVA'" :errorMessage="errorMessage" :successMessage="successMessage"/>
    </fieldset>
</template>

<script>
    import DMCreditorBACS from "./DMCreditorBACS";
    import IVACreditorBACS from "./IVACreditorBACS";

    export default {
        name: "NewBACSCreditorHome",
        components: {
            DMCreditorBACS,
            IVACreditorBACS
        },
        data() {
            return {
                selected: 'placeholder'
            }
        },
        methods: {
            successMessage() {
                this.$swal.fire({
                    icon: 'success',
                    title: 'Payment method changed to BACS!'
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
