<template>
    <div :class="[isSSRSDown ? 'border-red' : 'border-green', 'card-body shadow loadingSpinner']">
        <p class="font-colour card-title">SSRS Total Count</p>
        <h4 :class="[{ 'loader-print-manager': isLoading }, 'count-font card-text']">{{ latestCount }}
            <span :class="{ 'caret-green' : caretGreen, 'line-grey' : noChange, 'caret-red' : !caretGreen }"></span>
        </h4>
    </div>
</template>

<script>

export default {
    name: "SSRSPrintQueue",
    data() {
        return {
            latestCount: 0,
            previousCount: 0,
            thirtyMinCount: 0,
            countArray: [],
            timer: [],
            isSSRSDown: false,
            isLoading: false,
            updateTime: false
        }
    },
    created() {
        this.getSSRS();
        this.timer = setInterval(this.getSSRS, 300000);
    },
    computed: {
        caretGreen() {
            return this.latestCount < this.previousCount;
        },
        noChange() {
            return this.latestCount === this.previousCount;
        }
    },
    methods: {
        getSSRS() {
            let bearerToken = JSON.parse(localStorage.getItem('session')).bearer_token;
            let vm = this;

            vm.isLoading = true;

            axios
                .get(vm.$baseUrl + vm.$printQueuesUrl + vm.$ssrsView, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                })
                .then(response => {
                    vm.latestCount = response.data.latestCount;
                    vm.thirtyMinCount = response.data.thirtyMinCount;
                    vm.isSSRSDown = vm.thirtyMinCount > 0 && vm.latestCount > 30;

                    vm.countArray.push(vm.latestCount);

                    if (vm.countArray.length >= 3) {
                        vm.countArray.splice(vm.latestCount[0], 1);
                    }

                    vm.previousCount = vm.countArray[0];

                    vm.$emit('setUpdatedTime');

                    vm.isLoading = false;
                });
        }
    },
    beforeDestroy() {
        clearInterval(this.timer);
    }
}
</script>
