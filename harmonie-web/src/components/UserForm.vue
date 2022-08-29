<template>
  <div>

    <div class="field">
      <label class="label">Jméno a příjmení</label>
      <div class="control has-icons-left has-icons-right">
        <input
          :class="{input:true, 'is-danger': invalidUsername, 'is-success': !invalidUsername && user.username}"
          type="text"
          placeholder="jméno a příjmení"
          v-model="user.username"
          v-on:input="validateUsername"
        >
        <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
        <span class="icon is-small is-right">
          <i v-if="invalidUsername" class="fas fa-exclamation-triangle"></i>
          <i v-else class="fas fa-check"></i>
        </span>
      </div>
      <p v-if="invalidUsername" class="help is-danger">{{ invalidUsername }}</p>
    </div>

    <div class="field">
      <label class="label">Email</label>
      <div class="control has-icons-left has-icons-right">
        <input
          :class="{input:true, 'is-danger': invalidEmail, 'is-success': !invalidEmail && email}"
          type="email"
          placeholder="email"
          v-model="user.email"
          v-on:input="validateEmail"
        >
        <span class="icon is-small is-left">
          <i class="fas fa-envelope"></i>
        </span>
        <span class="icon is-small is-right">
          <i v-if="invalidEmail" class="fas fa-exclamation-triangle"></i>
          <i v-else class="fas fa-check"></i>
        </span>
      </div>
      <p v-if="invalidEmail" class="help is-danger">Neplatný email</p>
    </div>

    <div class="field">
      <label class="label">Heslo</label>
      <div class="control has-icons-left has-icons-right is-danger">
        <input
          :class="{input: true, 'is-danger': invalidPassword, 'is-success': !invalidPassword}"
          type="password"
          placeholder="heslo"
          v-model="user.password"
          v-on:input="validatePassword"
        >
        <span class="icon is-small is-left">
          <i class="fas fa-key"></i>
        </span>
        <span class="icon is-small is-right">
          <i v-if="invalidPassword" class="fas fa-exclamation-triangle"></i>
          <i v-else class="fas fa-check"></i>
        </span>
      </div>
      <p v-if="invalidPassword" class="help is-danger">{{ invalidPassword }}</p>
    </div>

    <div class="field">
      <label class="label">Heslo znovu</label>
      <div class="control has-icons-left has-icons-right">
        <input
          :class="{input: true, 'is-danger': passwordsDontMatch, 'is-success': !passwordsDontMatch}"
          type="password"
          placeholder="heslo znovu"
          v-model="user.password2"
          v-on:input="validatePassword"
        >
        <span class="icon is-small is-left">
          <i class="fas fa-key"></i>
        </span>
        <span class="icon is-small is-right">
          <i v-if="passwordsDontMatch" class="fas fa-exclamation-triangle"></i>
          <i v-else class="fas fa-check"></i>
        </span>
      </div>
      <p v-if="passwordsDontMatch" class="help is-danger">Hesla nesedí</p>
    </div>

    <div v-if="admin" class="field">
      <label class="label">Oprávnění</label>
      <div class="control">
        <div class="select">
          <select v-model="user.role">
            <option v-for="(role, key) in roles" :key="'user-form-' + key" :value="role">{{ roleMapping[role] || role }}</option>
          </select>
        </div>
      </div>
    </div>

    <div class="field is-grouped">
      <div class="control">
        <button 
          :disabled="invalidUsername || invalidEmail || invalidPassword || passwordsDontMatch"
          @click="submit"
          :class="{button: true, 'is-link': true, 'is-loading': loading}"
        >Odeslat</button>
      </div>
      <div class="control">
        <button @click="$emit('cancel')" class="button is-link is-light">Zrušit</button>
      </div>
    </div>

    <transition name="slide-fade">
    <article v-if="error" class="message is-danger">
      <div class="message-body">{{ error }}</div>
    </article>
    </transition>

  </div>
</template>

<script>
export default {

  props: ['inputUser', 'roles', 'allUsers', 'admin', 'loading', 'error'],

  data() {
    return {

      passwordsDontMatch: true,
      invalidUsername: "Zadej jméno",
      invalidPassword: "Zadej heslo",
      invalidEmail: false,

      user: {
        role: "member",
      },

      roleMapping: {
        'admin': 'Administrátor',
        'member': 'Člen orchestru'
      }
    }
  },

  methods: {
    cancel() {
      this.$emit("cancel");
    },
    submit() {
      if (this.user.password === "placeholder") {
        delete this.user.password;
        delete this.user.password2;
      }
      this.$emit("submit", this.user);
    },

    validateUsername() {
      if (!this.user.username) {
        this.invalidUsername  = "Zadej jméno";
      } else if (
        !this.inputUser &&
        this.allUsers &&
        this.allUsers.map(u => u.username).indexOf(this.user.username) !== -1
      ) {
        this.invalidUsername  = "Člen se tímto jménem už existuje";
      } else if (this.user.username.indexOf('@') !== -1) {
        this.invalidUsername  = "Jméno nesmí obsahovat '@'";
      } else {
        this.invalidUsername  = false;
      }
    },

    validateEmail() {
      // allow empty email
      if (this.user.email && this.user.email.split("@").filter(it => it.length > 0).length !== 2) {
        this.invalidEmail  = true;
      } else {
        this.invalidEmail  = false;
      }
    },

    validatePassword() {
      this.passwordsDontMatch = !this.user.password ||  this.user.password !== this.user.password2;

      if (!this.user.password || this.user.password.length < 6) {
        this.invalidPassword = "Heslo je příliš krátké";
      } else {
        this.invalidPassword = false;
      }
    }
  },

  created() {
    if (this.inputUser) {
      this.user = { ... this.inputUser }
      if (this.inputUser) {
        // Make it look like the form will be sent without password change
        this.user.password = "placeholder"
        this.user.password2 = "placeholder"
      }
      this.validateUsername();
      this.validatePassword();
    }
  }
}
</script>

<style>

</style>