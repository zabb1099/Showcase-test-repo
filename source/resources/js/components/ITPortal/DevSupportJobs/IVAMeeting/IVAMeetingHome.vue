<template>
    <div>
        <ul class="subMenuTwo">
            <li @click="toggle('meetingOutcome')" :class="{ selectedElement: selected.includes('meetingOutcome')}">
                <span>Meeting Outcome</span>
            </li>
            <li @click="toggle('removeSecondMeeting')" :class="{ selectedElement: selected.includes('removeSecondMeeting')}">
                <span>Remove Meeting</span>
            </li>
        </ul>
        <MeetingOutcome v-if="selected ==='meetingOutcome'" :errorMessage="errorMessage" />
        <RemoveSecondMeeting v-if="selected ==='removeSecondMeeting'" :errorMessage="errorMessage" />
    </div>
</template>
<script>
import RemoveSecondMeeting from "./RemoveSecondMeeting";
import MeetingOutcome from "./MeetingOutcome";

export default {
    name: "IVAMeetingHome",
    components: {
        MeetingOutcome,
        RemoveSecondMeeting
    },
    data() {
        return {
            selected: 'meetingOutcome'
        }
    },
    methods: {
        toggle(value) {
            if (value === 'meetingOutcome') this.selected = 'meetingOutcome';
            if (value === 'removeSecondMeeting') this.selected = 'removeSecondMeeting';
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
