<template>
    <div class="row m-5">
        <div v-for="(count, index) in counts" :key="index" class="col-sm-3">
            <div class="card text-center">
                <div :class="getBorderClasses(count)">
                    <p class="card-title font-colour">{{ count.title }}</p>
                    <h4 :class="getLoaderClasses()">{{ count.latestCount }}
                        <span :class="getCaretClass(count)" />
                    </h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "IVAPrintQueuesHome",
        data() {
            return {
                timer: [],
                total: 0,
                isLoading: false,
                counts: {
                    letters: { title: 'IVA Letter Count', latestCount: 0, previousCount: 0, countArray: [], status: '' },
                    emails: { title: 'IVA Email Count', latestCount: 0, previousCount: 0, countArray: [], status: '' },
                    sms: { title: 'IVA SMS Count', latestCount: 0, previousCount: 0, countArray: [], status: '' },
                    actionGroups: { title: 'IVA Action Group Count', latestCount: 0, previousCount: 0, countArray: [] }
                }
            }
        },
        computed: {
            allGreen() {
                return this.counts.letters.status === 'green' || this.counts.emails.status === 'green' ||
                    this.counts.sms.status === 'green' || this.counts.actionGroups.latestCount < this.counts.actionGroups.previousCount;
            },
            allAmber() {
                return !this.allGreen && !this.allRed;
            },
            allRed() {
                return this.counts.letters.status === 'red' && (this.counts.emails.status === 'red' || this.counts.emails.status === 'emailsDown') &&
                    this.counts.sms.status === 'red' && this.counts.actionGroups.latestCount >= this.counts.actionGroups.previousCount;
            },
            emailsDown() {
                return this.counts.emails.status === 'emailsDown' && (this.counts.letters.status === 'green' ||
                    this.counts.sms.status === 'green' || this.counts.actionGroups.latestCount < this.counts.actionGroups.previousCount);
            }
        },
        created() {
            this.getQueues();
            this.timer = setInterval(this.getQueues, 300000);
        },
        methods: {
            getQueues() {
                let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
                let vm = this;
                vm.isLoading = true;

                axios
                    .get(vm.$baseUrl + vm.$printQueuesUrl + vm.$debtsolvIvaView, {
                        headers: { "Authorization": `Bearer ${bearerToken}` }
                    })
                    .then(response => {
                        vm.counts.letters.latestCount = response.data.letters.count;
                        vm.counts.emails.latestCount = response.data.emails.count;
                        vm.counts.sms.latestCount = response.data.sms.count;
                        vm.counts.actionGroups.latestCount = response.data.actionGroups.count;
                        vm.counts.letters.status = response.data.letters.status;
                        vm.counts.emails.status = response.data.emails.status;
                        vm.counts.sms.status = response.data.sms.status;
                        vm.total = response.data.total;

                        Object.entries(vm.counts).forEach(([key]) => {
                            vm.counts[key].countArray.push(vm.counts[key].latestCount);
                            if (vm.counts[key].countArray.length >= 3) vm.counts[key].countArray.splice(vm.counts[key].latestCount[0], 1);
                            vm.counts[key].previousCount = vm.counts[key].countArray[0];
                        });

                        vm.$emit('setTotal', vm.total);
                        vm.$emit('setAllGreenIVA', vm.allGreen);
                        vm.$emit('setAllAmberIVA', vm.allAmber);
                        vm.$emit('setAllRedIVA', vm.allRed);

                        vm.isLoading = false;
                    });
            },
            getBorderClasses(count) {
                let classes = "card-body shadow loadingSpinner";
                if (this.allRed || (this.emailsDown && count.status === 'emailsDown')) return `border-red ${classes}`;
                if (this.allAmber) return `border-amber ${classes}`;
                if (this.allGreen) return `border-green ${classes}`;
            },
            getLoaderClasses() {
                let classes = "count-font card-text";
                if (this.isLoading) return `loader-print-manager ${classes}`;
                return `${classes}`
            },
            getCaretClass(count) {
                if (count.latestCount < count.previousCount) return 'caret-green';
                if (count.latestCount === count.previousCount) return 'line-grey';
                return 'caret-red';
            }
        },
        beforeDestroy() {
            clearInterval(this.timer);
        }
    }

</script>
