<template>
<div class="container">

  <Breadcrumbs :crumbs="crumbs"/>

  <div v-if="user">

    <section class="hero">
      <div class="hero-body pt-0">
        <p class="title">Rozpis</p>
        <p class="subtitle">zkoušek a akcí</p>
      </div>
    </section>    

    <!-- FILTER TAGS -->
    <div class="section tags py-0 ml-5">
      <a
        v-for="(type, key) in eventTypes" :key="key+'tag-type'+type"
        @click="clickFilter(type)"
        :class="{
          tag: true,
          'is-rounded': true,
          'is-primary': eventTypesFilters.indexOf(type) == -1
        }"
        style="text-decoration: none"
      >
        {{ eventTypesMap[type] || type }}
      </a>
    </div>

    <hr class="mt-1">

    <section v-if="events && events.length > 0" class="section pt-0">
      <RehearsalRow v-for="(event, index) in showedEvents" :key="'event' + index" :event="event"/>
    </section>
    <LoadingSection v-else-if="loading" :loading="true" />
    <section v-else class="hero has-text-centered">
      <div class="hero-body">
        <p class="title">
          <span class="icon mr-1">
            <i class="fa-solid fa-thumbs-up"></i>
          </span>
        </p>
      </div>
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
import axios from 'axios';
import Breadcrumbs from '../components/Breadcrumbs.vue';
import RehearsalRow from '../components/RehearsalRow.vue';
import LoadingSection from '../components/LoadingSection.vue';

export default {

    components: { Breadcrumbs, RehearsalRow, LoadingSection },

    inject: ['user'],

    data() {
      return {
        loading: false,
        events: [], // all events
        showedEvents: [],
        eventTypes: [],
        eventTypesFilters: [],
        eventTypesMap: {
          concert: "Koncerty",
          rehearsal: "Zkoušky",
          tour: "Zájezdy",
        },
        crumbs: [
            ['home', 'Domů'], ['members', 'Pro členy']
        ],
      }
    },

    created() {
      setTimeout(() => {
        if(!this.user) {
          // If not logged-in: show lock message and after
          // a couple of secs reroute to home view.
          this.$router.push({name:'home'})
        }
      }, 5000);

      this.getEvents()
    },

    methods: {

      clickFilter(type) {
        if (this.eventTypesFilters.indexOf(type) == -1) {
          this.eventTypesFilters.push(type)
        } else {
          this.eventTypesFilters = this.eventTypesFilters.filter(t => t !== type)
        }
        this.filterEvents();
      },

      filterEvents() {
        this.showedEvents = this.events
          .filter(event => this.eventTypesFilters.indexOf(event.type) == -1)
          .sort((a, b) => a.datetime > b.datetime ? 1 : -1);
      },

      getEvents() {
        const zero = new Date();
        zero.setHours(0, 0, 0);
        axios.get('/php/events_get.php')
           .then(res => {
              this.events = res.data
                  .filter(event => event.datetime && new Date(event.datetime) > zero)
                  .sort((a, b) => a.datetime > b.datetime ? 1 : -1);
              this.eventTypes = new Set(this.events.map(e => e.type));
              if (this.eventTypes.has('rehearsal')) {
                this.eventTypesFilters = ['concert', 'tour'];
              }

              this.filterEvents();
            })
      },
    },

}
</script>

<style>

</style>