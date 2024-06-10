<template>
    <div class="auth-page">
        <div class="head-title">
            <router-link to="/">
                <font-awesome-icon :icon="['fas', 'chevron-left']" />
                Back to Home
            </router-link>
        </div>
        <div class="logo"><img src="@/assets/img/logo.png" alt=""></div>
        <div class="head-action">
            <p @click="changeTab(true)" :class="{ active: isLogin }">Login</p>
            <p @click="changeTab(false)" :class="{ active: !isLogin }">Register</p>
            <span ref="tabIndicator"></span>
        </div>
        <div class="wrapper-form">

            <form ref="AuthForm" v-if="isLogin" action="" class="login">
                <div class="form-group">
                    <input name="username" v-model="input.username" type="text" required="required"
                        @focus="removeError">
                    <font-awesome-icon class="icon2" :icon="['fas', 'user']" />
                    <label for="username">Account</label>
                    <span class="message"></span>
                </div>
                <div class="form-group">
                    <input name="password" :type="typePassword ? 'password' : 'text'" v-model="input.password"
                        @focus="removeError" required="required">
                    <font-awesome-icon class="icon2" :icon="['fas', 'lock']" />
                    <font-awesome-icon class="icon" :icon="['far', !displayPassword ? 'eye-slash' : 'eye']"
                        @mousedown="handleDisplayPassword(1)" />
                    <label for="password">Password</label>
                    <span class="message"></span>
                </div>
                <div class="form-group">
                    <input name="verify_code" v-model="input.verify_code" type="text" required="required"
                        @focus="removeError">
                    <font-awesome-icon class="icon2" :icon="['fas', 'shield']" />
                    <img :src="captcha_src" alt="captcha" @click="getVerifyCode">
                    <label>Verify Code</label>
                    <span class="message"></span>
                </div>
                <div class="footer">
                    <div class="left">
                        <input type="checkbox">
                        <label>Remember me</label>
                    </div>
                    <div class="right">
                        <router-link to="#">Forget Password</router-link>
                    </div>
                </div>

            </form>
            <form v-else ref="AuthForm" action="" class="register">
                <div class="form-group">
                    <input name="username" type="text" required="required" v-model="input.username"
                        @focus="removeError">
                    <font-awesome-icon class="icon2" :icon="['fas', 'user']" />
                    <label for="username">Account</label>
                    <span class="message"></span>
                </div>
                <div class="form-group">
                    <input name="password" :type="typePassword ? 'password' : 'text'" required="required"
                        v-model="input.password" @focus="removeError">
                    <font-awesome-icon class="icon2" :icon="['fas', 'lock']" />
                    <font-awesome-icon class="icon" :icon="['far', !displayPassword ? 'eye-slash' : 'eye']"
                        @mousedown="handleDisplayPassword(1)" />
                    <label for="password">Password</label>
                    <span class="message"></span>
                </div>
                <div class="form-group">
                    <input name="password_confirm" :type="typeConfirmPassword ? 'password' : 'text'"
                        v-model="input.password_confirm" required="required" @focus="removeError">
                    <font-awesome-icon class="icon2" :icon="['fas', 'lock']" />
                    <font-awesome-icon class="icon" :icon="['far', !displayConfirmPassword ? 'eye-slash' : 'eye']"
                        @mousedown="handleDisplayPassword(2)" />
                    <label for="password_confirm">Confirm Password</label>
                    <span class="message"></span>
                </div>
                <div class="form-group">
                    <input name="invite_code" v-model="input.invite_code" type="text" required="required"
                        autocomplete="off">
                    <font-awesome-icon class="icon2" :icon="['fas', 'users']" />
                    <label>Invite Code</label>
                    <span class="message"></span>
                </div>
                <div class="form-group">
                    <input name="verify_code" v-model="input.verify_code" type="text" required="required"
                        autocomplete="off" @focus="removeError">
                    <font-awesome-icon class="icon2" :icon="['fas', 'shield']" />
                    <img :src="captcha_src" alt="captcha" @click="getVerifyCode">
                    <label>Verify Code</label>
                    <span class="message"></span>
                </div>
            </form>
            <ul class="action">
                <li @click="auth">{{ btnAuth }}</li>
                <li> <span class="text">Or</span></li>
                <li>
                    <p><img src="@/assets/img/auth/google.png" alt=""><span>Continute with Google</span></p>
                </li>
                <li>
                    <p><img src="@/assets/img/auth/facebook.png" alt=""><span>Continute with FaceBook</span></p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import Back from '@/components/Back.vue';
import { layer } from '@layui/layer-vue';

export default {
    components: {
        Back
    },
    data() {
        return {
            captcha_src: '',
            uniqid: '',
            input: {
                username: '',
                password: '',
                password_confirm: '',
                invite_code: '',
                verify_code: ''
            },
            isLogin: true,
            typePassword: true,
            typeConfirmPassword: true,
            displayPassword: false,
            displayConfirmPassword: false,
            btnAuth: 'Login'
        }
    },
    created() {

        this.getVerifyCode()

    },
    mounted() {
        this.checkLogin()
    },

    methods: {
        checkLogin() {
            const isLogin = JSON.parse(localStorage.getItem('isLogin'));
            if (isLogin) {
                this.$router.push({ name: 'Home' })
            } else {
                const task = this.$route.params.task;
                let params = 'login'
                if (task == 'register') {
                    params = 'register'
                    this.changeTab(false)
                }
                this.$router.replace({ name: 'Auth', params: { task: params } });
            }
        },
        auth() {
            let validate = true;
            if (this.isLogin) {
                validate = this.validate()
            } else {
                validate = this.validate('register')
            }
            if (!validate) {
                this.getVerifyCode()
                return;
            }
            const params = {
                verify_code: this.input.verify_code,
                uniqid: this.uniqid,
                username: this.input.username,
                password: this.input.password,
                login_type: true
            }
            if (!this.isLogin) {
                params.password_confirm = this.input.password_confirm;
                params.invite_code = this.input.invite_code;
                params.login_type = false;
            }

            layer.load(2)
            this.$wedApi.post('Guest/auth', params).then(res => {
                layer.closeAll('loading')
                const data = res.data;
                if (data.code === 1) {
                    layer.msg(data.info, { icon: 6, time: 1000 })
                    localStorage.setItem('isLogin', true);
                    localStorage.setItem('token', data.data.token);
                    localStorage.setItem('userInfo', JSON.stringify(data.data));
                    this.$socket.emit('updateUserInfo', data.data);
                    setTimeout(() => {
                        this.$router.push({ name: 'Home' })
                    }, 1000)

                } else {
                    layer.msg(data.info, { icon: 5, time: 1000 })
                    this.getVerifyCode()
                }

            })
        },
        validate(type = 'login') {
            const form = this.$refs.AuthForm;
            let validate = true;
            const inputVal = {
                username: this.input.username,
                password: this.input.password,
                verify_code: this.input.verify_code

            };
            if (type == 'register') {
                inputVal.password_confirm = this.input.password_confirm;
            }

            for (let key in inputVal) {
                if (inputVal.hasOwnProperty(key) && inputVal[key] == '') {
                    const input = form.querySelector(`input[name="${key}"]`);
                    input.parentElement.classList.add('error');
                    const label = input.parentElement.querySelector('label').innerText;
                    input.parentElement.querySelector('.message').innerText = label + ' is required';
                    validate = false;
                }
            }

            if (!validate) return false;
            return true;
        },
        removeError(e) {
            e.target.parentElement.classList.remove('error');
            e.target.parentElement.querySelector('.message').innerText = '';
        },
        getVerifyCode() {
            this.$wedApi.get('Guest/getVerifyCode').then(res => {
                this.captcha_src = res.data.data.captcha_src;
                this.uniqid = res.data.data.uniqid;
            })
        },

        changeTab(isLogin) {
            this.isLogin = isLogin;
            const tabIndicator = this.$refs.tabIndicator;
            let params = 'login'
            this.btnAuth = 'Login'
            if (!isLogin) {
                params = 'register';
                this.btnAuth = 'Register'
                tabIndicator.style.left = '50%';
            } else {
                tabIndicator.style.left = '0';
            }
            this.$router.replace({ name: 'Auth', params: { task: params } });
        },
        handleDisplayPassword(type) {
            if (type == 1) {
                this.typePassword = !this.typePassword;
                this.displayPassword = !this.displayPassword;
            } else {
                this.typeConfirmPassword = !this.typeConfirmPassword;
                this.displayConfirmPassword = !this.displayConfirmPassword;
            }
        }
    }
}

</script>

<style lang="scss" scoped></style>