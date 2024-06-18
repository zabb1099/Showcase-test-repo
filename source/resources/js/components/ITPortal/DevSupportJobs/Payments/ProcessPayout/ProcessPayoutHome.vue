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
        <ProcessPayoutDM v-if="selected ==='DM'" :errorMessage="errorMessage" :successMessage="successMessage"/>
        <ProcessPayoutIVA v-if="selected ==='IVA'" :errorMessage="errorMessage" :successMessage="successMessage"/>
    </fieldset>
</template>

<script>
    import ProcessPayoutDM from "./ProcessPayoutDM";
    import ProcessPayoutIVA from "./ProcessPayoutIVA";

    export default {
        name: "ProcessPayoutHome",
        components: {
            ProcessPayoutDM,
            ProcessPayoutIVA
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
                    title: 'Payout Processed!'
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
