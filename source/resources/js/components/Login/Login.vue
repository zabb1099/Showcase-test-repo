<template>
    <div id="bfgBackground">
        <img id="logoBackground" :src="bfgLogo" alt="Logo">
        <div id="loginForm">
            <form @submit.prevent="submitLogin" autocomplete="on">
                <div id="loginTitle">BW Portal</div>
                <input type="text" id="usernameLogin" placeholder="Username" v-model="username" required><br>
                <div id="password">
                    <input :type="showInput ? 'text' : 'password'" id="passwordLoginInput" placeholder="Password"
                           v-model="password" required>
                    <span>
                        <img type="password" :src="eye" alt="Icon" id="eyePasswordLogin" @click="switchVisibility">
                    </span>
                </div>
                <div>
                    <div v-if="loading">
                        <button class="btnLogin" type="button" disabled>
                            <span class="spinner-border spinnerStyling" role="status" aria-hidden="true"></span>
                            LOADING...
                        </button>
                    </div>
                    <div v-else>
                        <button id="submitLogin" type="button" @click="submitLogin">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>
        <span v-if="errorMessage" class="active text-white mb-3 mt-3 d-flex justify-content-center">
            {{ this.errorMessageText }}
        </span>
    </div>
</template>

<script>

export default {
    data() {
        return {
            eye: '/images/Login/password.svg',
            bfgLogo: '/images/Login/logoLogin.svg',
            username: '',
            password: '',
            showInput: false,
            errorMessage: false,
            errorMessageText: '',
            loading: false
        }
    },
    methods: {
        switchVisibility() {
            this.showInput = !this.showInput;
        },
        submitLogin() {
            this.errorMessage = false;
            this.loading = true;
            let username = this.username;
            let password = this.password;

            axios.post(this.$baseUrl + '/oauth/token', {
                grant_type: "password",
                client_id: process.env.MIX_VUE_APP_CLIENT_ID,
                client_secret: process.env.MIX_VUE_APP_CLIENT_SECRET,
                username: username,
                password: password,
                scope: '*'
            }).then(response => {
                let bearerToken = response.data.access_token;
                let expires_in = response.data.expires_in;
                let refreshToken = response.data.refresh_token;
                window.counter = new Date().getTime();

                axios.get(this.$baseUrl + this.$userInformationUrl, {
                    headers: {
                        "Authorization": `Bearer ${bearerToken}`
                    }
                }).then(response => {
                    this.loading = false;
                    let session = {
                        USR_Full_Name: response.data.USR_Full_Name,
                        USR_ID: response.data.USR_ID,
                        bearer_token: bearerToken,
                        UST_ID: response.data.UST_ID,
                        USR_Unlimited: response.data.USR_Unlimited,
                        expires_in: expires_in,
                        refresh_token: refreshToken,
                        counter: new Date().getTime()
                    }
                    localStorage.setItem('session', JSON.stringify(session));
                    this.$router.push({
                        path: this.$itPortalView + this.$devSupportJobsView
                    });
                }).catch((error) => {
                    this.handleError(error);
                });

            }).catch(error => {
                this.handleError(error);
            });
        },
        handleError(error) {
            this.errorMessageText = error.response.data.message;
            this.loading = false;
            this.errorMessage = true;
            this.username = '';
            this.password = '';
        }
    }
}
</script>
