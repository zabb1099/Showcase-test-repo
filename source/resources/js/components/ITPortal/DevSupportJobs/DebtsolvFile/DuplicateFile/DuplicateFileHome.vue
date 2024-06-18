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
        <DuplicateFileDM v-if="selected === 'DM'" :errorMessage="errorMessage" />
        <DuplicateFileIVA v-if="selected === 'IVA'" :errorMessage="errorMessage" />
    </fieldset>
</template>

<script>
    import DuplicateFileDM from "./DuplicateFileDM";
    import DuplicateFileIVA from "./DuplicateFileIVA";

    export default {
        name: "DuplicateFileHome",
        components: {
            DuplicateFileDM,
            DuplicateFileIVA
        },
        data() {
            return {
                selected: 'placeholder'
            }
        },
        methods: {
            errorMessage() {
                this.$swal.fire({
                    icon: 'error',
                    title: 'There are no duplicate files to remove!'
                });
            }
        }
    }
</script>
