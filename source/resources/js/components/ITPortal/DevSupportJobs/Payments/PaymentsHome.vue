<template>
    <div>
        <ul class="subMenuTwo">
            <li v-for="link in links" :key="link.id" @click="selected = link.value" :class="{ selectedElement: selected.includes(link.value)}">
                <span>{{ link.name }}</span>
            </li>
        </ul>
        <NewBACSCreditorHome v-if="selected ==='newBacs'" :errorMessage="errorMessage"/>
        <ProcessPayoutHome v-if="selected ==='processPayout'" :errorMessage="errorMessage"/>
        <BulkCreditorHome v-if="selected ==='bulkCreditor'" :errorMessage="errorMessage"/>
        <CardPaymentHome v-if="selected ==='cardPayment'" :errorMessage="errorMessage" />
    </div>
</template>

<script>
    import NewBACSCreditorHome from "./NewBACSCreditor/NewBACSCreditorHome";
    import ProcessPayoutHome from "./ProcessPayout/ProcessPayoutHome";
    import BulkCreditorHome from "./BulkCreditor/BulkCreditorHome";
    import CardPaymentHome from "./CardPayment/CardPaymentHome";

    export default {
        name: "PaymentsHome",
        components: {
            NewBACSCreditorHome,
            ProcessPayoutHome,
            BulkCreditorHome,
            CardPaymentHome
        },
        data() {
            return {
                selected: 'cardPayment',
                links: [
                    {name: 'Card Payment Error', value: 'cardPayment'},
                    {name: 'New BACS', value: 'newBacs'},
                    {name: 'Process Payout', value: 'processPayout'},
                    {name: 'Remittances', value: 'bulkCreditor'},
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
