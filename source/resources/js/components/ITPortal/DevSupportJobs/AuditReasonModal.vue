<template>
        <div id="audit" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="title-header modal-header">
                        <h5 class="modal-title">Reason for Change</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form class="form-flex" @submit.prevent>
                                <div class="form-flex-item no-border-bottom">
                                    <label class="form-label">Reason:</label>
                                    <input class="form-field" type="text" v-model.trim="$v.auditReason.$model">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="closeModal" type="button" class="blue-btn">
                            &#10005; Cancel
                        </button>
                        <button @click="submitAudit" class="search-btn green-btn"
                                :class="{disabled: !$v.auditReason.required}"
                                :disabled="!$v.auditReason.required">
                            &#10003; Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import $ from 'jquery';
import {required} from 'vuelidate/lib/validators';

export default {
    name: "AuditReasonModal",
    props: {
        doShow: Boolean
    },
    validations: {
        auditReason: {
            required
        }
    },
    data() {
        return {
            auditReason: '',
            shouldSubmit: false
        }
    },
    watch: {
        doShow() {
            this.toggleModal();
        }
    },
    methods: {
        toggleModal() {
          if (this.doShow) {
              $('#audit').modal('show');
          }  else {
              $('#audit').modal('hide');
          }
        },
        closeModal() {
            this.$emit('close');
            this.auditReason = '';
        },
        submitAudit() {
            this.$emit('submitAuditReason', this.auditReason);
            this.auditReason = '';
            this.shouldSubmit = !this.shouldSubmit;
        }
    },
    mounted(){
        this.toggleModal();
    }
}
</script>

