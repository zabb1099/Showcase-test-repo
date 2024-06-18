<template>
    <div id="pageNotFound">
        <div class="mainbox">
            <div class="err">4</div>
            <div class="err2">0</div>
            <div class="err3">4</div>
            <div class="msg">Maybe this page moved? Got deleted? Is hiding out in quarantine? Never existed in the first place?
                <p>Let's go <router-link class="urlLinkStyle" to="/login">home</router-link> and try from there.</p>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'NotFound',
}

</script>
