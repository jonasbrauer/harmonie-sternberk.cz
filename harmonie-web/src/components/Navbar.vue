<script>
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

    inject: ['user'],

    methods: {
        login() {
            this.loginLoading = true;
            axios.post('/php/login.php', this.credentials)
                 .then(res => {
                     this.$emit('login');
                     this.loginError = false;
                     this.modalActive = false;
                     this.credentials = {};
                    })
                 .catch(err => this.loginError = true)
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

                const loginOnlyRoutes = ['members'];
                if (loginOnlyRoutes.indexOf(this.$route.name) != -1) {
                    this.$router.push({ name: 'home'});
                }
            })
            .finally(() => this.logoutLoading = false)
        }
    }
}
</script>

<template>
<div>

    <div class="navbar mt-3">
    <div class="navbar-brand">
        <RouterLink class="navbar-item" :to="{name: 'home'}" v-on:click="menuActive=false">
            <img src="@/assets/logo.png">
            <span class="ml-3 title is-5 has-text-primary">HARMONIE ŠTERNBERK</span>
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
    </div>


    <div :class="{
        'navbar-menu': true,
        'mt-5': true,
        'is-active': menuActive,
        }"
        style="z-index: -1;"
    >
        <div class="navbar-start">
        
            <RouterLink v-on:click="menuActive=false" class="navbar-item" :to="{name: 'program'}">Program</RouterLink>

            <RouterLink v-on:click="menuActive=false" class="navbar-item" :to="{name: 'dirigent'}">Dirigent</RouterLink>

            <RouterLink v-on:click="menuActive=false" class="navbar-item" :to="{name: 'orchestr'}">Orchestr</RouterLink>

            <RouterLink v-on:click="menuActive=false" class="navbar-item" :to="{name: 'gallery'}">Galerie</RouterLink>

            <RouterLink v-on:click="menuActive=false" class="navbar-item" :to="{name: 'success'}">Historie a úspěchy orchestru</RouterLink>

            <RouterLink v-if="user" v-on:click="menuActive=false" class="navbar-item" :to="{name: 'members'}">Sekce pro členy</RouterLink>

            <RouterLink v-if="user && user.role === 'admin'" v-on:click="menuActive=false" class="navbar-item" :to="{name: 'admin'}">Administrace</RouterLink>

        </div>

        <div class="navbar-end">
        <div v-if="!user" class="navbar-item">
            <button v-on:click="modalActive = !modalActive; menuActive = false;"
                    :class="{
                        button: true,
                        'is-rounded': true,
                        'is-primary': true,
                        'is-loading': loginLoading,
                    }">
                <span class="icon">
                    <i class="fa-solid fa-users"></i>
                </span>
                <span>Pro členy</span>
                
            </button>

        </div>
        
        <div v-else class="navbar-item">
        <button v-on:click="logout" :class="{
            button: true,
            'is-rounded': true,
            'is-loading': logoutLoading,
        }">
            <span class="icon-text">
            <span><strong>{{ user.username }}</strong></span>
            <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
            </span>
            
        </button>
        </div>

        </div>
    </div>

    <div :class="{modal: true, 'is-active': modalActive}">
        <div class="modal-background"></div>
        <div class="modal-content" style="min-height: 50%;">
            <form class="box">

            <!-- LOGIN -->
            <div class="field">
            <label class="label">Login</label>
            <div class="control has-icons-left has-icons-right">
                <input v-model="credentials.username" class="input" type="email" placeholder="jan.novak@gmail.com">
                <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
            </div>
            </div>

            <!-- PSWD -->
            <div class="field">
            <label class="label">Heslo</label>
            <div class="control has-icons-left has-icons-right">
                <input 
                    v-model="credentials.password" class="input" type="password" placeholder="********"
                    :class="{
                        input: true,
                        'is-danger': loginError
                }">
                <span class="icon is-small is-left"><i class="fas fa-key"></i></span>
            </div>
            <p v-if="loginError" class="help is-danger">Špatně zadané heslo</p>
            </div>

            <!-- REMEMBER ME -->
            <div class="field">
                <div class="control">
                    <label class="checkbox">
                    <input v-model="credentials.rememberme" type="checkbox" class="mr-1">
                    Pamatovat příhlášení
                    </label>
                </div>
                </div>

            <button
                v-on:click="login()"
                :class="{
                    button: true,
                    'is-primary': true,
                    'mt-3': true,
                    'is-loading': loginLoading,
            }">Příhlásit se</button>

            </form>
        <button v-on:click="modalActive = false" class="modal-close is-large" aria-label="close"></button>
        </div>
    </div>

</div>
</template>

<style>
</style>