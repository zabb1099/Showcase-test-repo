<template>
    <fieldset class="pageSize">
        <div class="row ml-5 mr-5">
            <div class="col-sm-12">
                <div class="card-row">
                    <div class="card-body shadow">
                        <div class="float-left">
                            <h4 class="count-font mb-0">{{ lastUpdatedDate }}</h4>
                        </div>
                        <div class="float-right">
                            <p class="font-colour mb-0">Last Updated:
                                <span class="count-font">{{ lastUpdatedTime }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <DMPrintQueues @setTotal="getTotalDM" @setAllGreenDM="getAllGreenDM"
                       @setAllAmberDM="getAllAmberDM" @setAllRedDM="getAllRedDM">
        </DMPrintQueues>
        <IVAPrintQueues @setTotal="getTotalIVA" @setAllGreenIVA="getAllGreenIVA"
                        @setAllAmberIVA="getAllAmberIVA" @setAllRedIVA="getAllRedIVA">
        </IVAPrintQueues>

        <div class="row m-5">
            <div class="col-sm-4">
                <div class="card text-center">
                    <div :class="[{ 'border-green' : allGreenDM, 'border-amber' : allAmberDM, 'border-red' : allRedDM },
                                'card-body shadow loadingSpinner']">
                        <p class="font-colour card-title">DM Total Count</p>
                        <h4 class="count-font card-text">{{ totalDM }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center">
                    <div :class="[{ 'border-green' : allGreenIVA, 'border-amber' : allAmberIVA, 'border-red' : allRedIVA },
                                'card-body shadow loadingSpinner']">
                        <p class="font-colour card-title">IVA Total Count</p>
                        <h4 class="count-font card-text">{{ totalIVA }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center">
                    <SSRSPrintQueue @setUpdatedTime="getUpdatedTime"></SSRSPrintQueue>
                </div>
            </div>
        </div>
    </fieldset>
</template>

<script>

import moment from "moment";
import SSRSPrintQueue from "./SSRSPrintQueue";
import DMPrintQueues from "./DMPrintQueues";
import IVAPrintQueues from "./IVAPrintQueues";

export default {
    name: "PrintQueuesHome",
    components: {
        SSRSPrintQueue,
        DMPrintQueues,
        IVAPrintQueues
    },
    data() {
        return {
            moment: moment,
            lastUpdatedTime: '',
            allGreenDM: false,
            allAmberDM: false,
            allRedDM: false,
            totalDM: 0,
            allGreenIVA: false,
            allAmberIVA: false,
            allRedIVA: false,
            totalIVA: 0
        }
    },
    computed: {
        lastUpdatedDate() {
            return moment().format('Do MMMM YYYY');
        }
    },
    methods: {
        getUpdatedTime() {
            this.lastUpdatedTime = moment().format('HH:mm:ss');
        },
        getTotalDM(total) {
            this.totalDM = total;
        },
        getTotalIVA(total) {
            this.totalIVA = total;
        },
        getAllGreenDM(green) {
            this.allGreenDM = green;
        },
        getAllAmberDM(amber) {
            this.allAmberDM = amber;
        },
        getAllRedDM(red) {
            this.allRedDM = red;
        },
        getAllGreenIVA(green) {
            this.allGreenIVA = green;
        },
        getAllAmberIVA(amber) {
            this.allAmberIVA = amber;
        },
        getAllRedIVA(red) {
            this.allRedIVA = red;
        }
    }
}
</script>
