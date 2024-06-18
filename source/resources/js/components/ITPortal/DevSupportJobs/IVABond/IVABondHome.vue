<template>
    <div>
        <ul class="subMenuTwo">
            <li @click="toggle('bondRenewalDate')" :class="{ selectedElement: selected.includes('bondRenewalDate')}">
                <span>Bond Renewal Date</span>
            </li>
            <li @click="toggle('removeDuplicateBond')" :class="{ selectedElement: selected.includes('removeDuplicateBond')}">
                <span>Duplicate Bond</span>
            </li>
        </ul>
        <BondRenewalDate v-if="selected ==='bondRenewalDate'" />
        <RemoveDuplicateBond v-if="selected ==='removeDuplicateBond'" />
    </div>
</template>
<script>

import RemoveDuplicateBond from "./RemoveDuplicateBond";
import BondRenewalDate from "./BondRenewalDate";

export default {
    name: "IVABondHome",
    components: {
        BondRenewalDate,
        RemoveDuplicateBond
    },
    data() {
        return {
            selected: 'bondRenewalDate'
        }
    },
    methods: {
        toggle(value) {
            if (value === 'bondRenewalDate') this.selected = 'bondRenewalDate';
            if (value === 'removeDuplicateBond') this.selected = 'removeDuplicateBond';
        }
    }
}
</script>
