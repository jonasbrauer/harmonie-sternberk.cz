<template>
<div>

    <div class="navbar">
        <div class="navbar-brand">
            <RouterLink class="navbar-item" :to="{name: 'home'}" v-on:click="menuActive=false">
                <img src="@/assets/logo.png">
            </RouterLink>

            <a v-on:click="menuActive = !menuActive" role="button"
                :class="{
                    'mt-2': true,
                    'navbar-burger': true,
                    'is-active': menuActive
                }" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div :class="{ 'navbar-menu': true, 'is-active': menuActive }">
            <div class="navbar-start">
            
                <RouterLink v-on:click="menuActive=false" class="navbar-item" :to="{name: 'program'}">Program</RouterLink>

                <RouterLink v-on:click="menuActive=false" class="navbar-item" :to="{name: 'orchestr'}">Orchestr</RouterLink>

                <RouterLink v-on:click="menuActive=false" class="navbar-item" :to="{name: 'gallery'}">Galerie</RouterLink>

                <RouterLink v-if="user" v-on:click="menuActive=false" class="navbar-item" :to="{name: 'members'}">Sekce pro členy</RouterLink>

                <RouterLink v-if="user && user.role === 'admin'" v-on:click="menuActive=false" class="navbar-item" :to="{name: 'admin'}">Administrace</RouterLink>

            </div>

            <div class="navbar-end">
            <div v-if="!user" class="navbar-item">
                <button
                    v-on:click="modalActive = !modalActive; menuActive = false;"
                    :class="{
                        button: true,
                        'is-rounded': true,
                        'is-primary': true,
                        'is-loading': loginLoading,
                        'is-outlined': true,
                        'is-small': true,
                    }">
                    <span class="icon">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <span>Pro členy</span>
                </button>
            </div>
            
            <div v-else class="navbar-item is-flex is-align-items-center">
            <span>
                <strong>{{ user.username.split(" ")[0] }}</strong>
            </span>
            <button v-on:click="logout" :class="{
                button: true,
                'ml-2': true,
                'is-small': true,
                'is-rounded': false,
                'is-loading': logoutLoading,
            }">
            <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
            </button>
            </div>

            </div>

        </div>
    </div>

    <!-- MODAL LOGIN FORM -->
    <div :class="{modal: true, 'is-active': modalActive}">
        <div class="modal-background"></div>
        <div class="modal-content" style="min-height: 50%;">
            <div v-if="modalActive" class="box">
                <LoginForm @login="login" :loading="loginLoading" :error="loginError" />
            </div>

        <button v-on:click="modalActive = false" class="modal-close is-large" aria-label="close"></button>
        </div>
    </div>

</div>
</template>

<script>
import LoginForm from './LoginForm.vue';
import axios from 'axios';

export default {

    data() {
        return {
            menuActive: false,
            modalActive: false,

            credentials: {},
            loginError: false,
            loginLoading: false,
            logoutLoading: false,
        }
    },
    
    components: { LoginForm },

    inject: ['user'],

    methods: {
        login(credentials) {
            this.loginLoading = true;
            axios.post('/php/login.php', credentials)
                 .then(res => {
                     this.$emit('login');
                     this.loginError = false;
                     this.modalActive = false;
                     this.credentials = {};
                     this.$router.push({name: 'members'});
                    })
                 .catch(err => {
                     this.loginError = true
                     console.error(err)
                    })
                 .finally(() => {
                     this.loginLoading = false;
                    })
        },

        logout() {
            this.logoutLoading = true;
            axios
            .delete('/php/login.php')
            .then(res => {
                this.$emit('logout');
                this.menuActive = false;

                const loginOnlyRoutes = ['members', 'admin'];
                if (loginOnlyRoutes.indexOf(this.$route.name) != -1) {
                    this.$router.push({ name: 'home'});
                }
            })
            .finally(() => this.logoutLoading = false)
        }
    }
}
</script>

<style>
</style>