<template>
  <div>
    <!-- LOGIN -->
    <div class="field">
    <label class="label">Login</label>
    <div class="control has-icons-left has-icons-right">
        <input v-model="credentials.username" class="input" placeholder="jan.novak@gmail.com">
        <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
    </div>
    <p class="help">Uživatelské Jméno nebo email</p>
    </div>

    <!-- PSWD -->
    <div class="field">
    <label class="label">Heslo</label>
    <div class="control has-icons-left has-icons-right">
        <input 
            v-model="credentials.password" class="input" type="password" placeholder="********"
            :class="{
                input: true,
                'is-danger': error
        }">
        <span class="icon is-small is-left"><i class="fas fa-key"></i></span>
    </div>
    <p v-if="error" class="help is-danger">Chybné přihlášení</p>
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

    <button @click="$emit('login', credentials)"
        :class="{
          button: true,
          'is-primary': true,
          'mt-3': true,
          'is-loading': loading,
        }"
        :disabled="!credentials.username || !credentials.password"
    >Příhlásit se</button>
  </div>
</template>

<script>
export default {

  props: ['loading', 'error'],

  data() {
    return {
      credentials: {},
    }
  }

}
</script>

<style>

</style>