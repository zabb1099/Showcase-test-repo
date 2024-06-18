<template>
    <div>
        <ul class="subMenuOne">
            <li v-for="link in links" :key="link.id" @click="selected = link.value" :class="{ selectedElement: selected.includes(link.value)}">
                <span>{{ link.name }}</span>
            </li>
        </ul>
        <div class="pt-3">
            <ClientFileLockedHome v-if="selected ==='clientFileLocked'"/>
            <IVABondHome v-if="selected ==='ivaBond'"/>
            <PaymentsHome v-if="selected ==='payments'"/>
            <IVAMeetingHome v-if="selected ==='ivaMeeting'"/>
            <LeadsUserHome v-if="selected ==='leadsUser'"/>
            <XMLGenerationHome v-if="selected ==='xmlGeneration'"/>
            <IsRX1RequiredHome v-if="selected ==='isRX1Required'"/>
            <DebtsolvFileHome v-if="selected ==='debtsolvFile'"/>
            <FSSUserHome v-if="selected ==='fssUser'"/>
        </div>
    </div>
</template>

<script>
    import ClientFileLockedHome from "./ClientFileLocked/ClientFileLockedHome";
    import IVABondHome from "./IVABond/IVABondHome";
    import PaymentsHome from "./Payments/PaymentsHome";
    import IVAMeetingHome from "./IVAMeeting/IVAMeetingHome";
    import LeadsUserHome from "./LeadsUser/LeadsUserHome";
    import XMLGenerationHome from "./GenerateXML/XMLGenerationHome";
    import IsRX1RequiredHome from "./IsRX1Required/IsRX1RequiredHome";
    import DebtsolvFileHome from "./DebtsolvFile/DebtsolvFileHome";
    import FSSUserHome from "./FSSUser/FSSUserHome";

    export default {
        name: "DevSupportJobsHome",
        components: {
            ClientFileLockedHome,
            IVABondHome,
            PaymentsHome,
            IVAMeetingHome,
            LeadsUserHome,
            XMLGenerationHome,
            IsRX1RequiredHome,
            DebtsolvFileHome,
            FSSUserHome
        },
        data() {
            return {
                selected: 'fssUser',
                links: [
                    {name: 'BFG Portal', value: 'fssUser'},
                    {name: 'Debtsolv File', value: 'debtsolvFile'},
                    {name: 'IVA Bond', value: 'ivaBond'},
                    {name: 'IVA Meeting', value: 'ivaMeeting'},
                    {name: 'Leads System', value: 'leadsUser'},
                    {name: 'Payments', value: 'payments'},
                    {name: 'RX1 / SoP', value: 'isRX1Required'},
                    {name: 'Unlock File', value: 'clientFileLocked'},
                    {name: 'XML Generation', value: 'xmlGeneration'},
                ]
            }
        }
    }
</script>

