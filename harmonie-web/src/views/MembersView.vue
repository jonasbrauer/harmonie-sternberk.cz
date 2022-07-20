<template>
<div class="container">

  <Breadcrumbs :crumbs="crumbs"/>
  <div v-if="user">

    <section class="hero">
      <div class="hero-body pt-0">
        <p class="title">
          Rozpis
        </p>
        <p class="subtitle">
          zkoušek a akcí
        </p>
      </div>
    </section>    

    <section class="section pt-0">
      <RehearsalRow v-for="(event, index) in events" :key="'event' + index" :event="event"/>
    </section>

  </div>

  <!-- Hide everything away for for unauthorized users -->
  <div v-else>

    <section class="hero is-medium has-text-centered">
      <div class="hero-body">
        <p class="title">
          <span class="icon mr-1">
            <i class="fa-solid fa-lock"></i>
          </span>
          Ups...
        </p>
        <p class="subtitle">
           Pro zobrazení sekce pro členy je nutné se přihlásit.
        </p>
      </div>
    </section>

  </div>

</div>
</template>

<script>
import Breadcrumbs from '../components/Breadcrumbs.vue'
import RehearsalRow from '../components/RehearsalRow.vue'

export default {

    components: { Breadcrumbs, RehearsalRow },

    inject: ['user'],

    created() {
      setTimeout(() => {
        if(!this.user) {
          // If not logged-in: show lock message and after
          // a couple of secs reroute to home view.
          this.$router.push({name:'home'})
        }
      }, 10000);
    },

    data() {
        return {
          events: [
            // #TODO: query all the events (members only included)
          ],
          crumbs: [
              ['home', 'Domů'], ['members', 'Pro členy']
          ],
        }
    },

}
</script>

<style>

</style>