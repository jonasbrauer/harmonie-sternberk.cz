<template>
<div>

  <main>
    <Carousel />

    <div class="container mt-3">    

      <section class="hero has-text-centered">
        <div class="hero-body pb-2">
          
          <p class="title is-4">
            <span class="icon mr-2">
              <i class="fa-solid fa-calendar-days"></i>
            </span>
            NEJBLIŽŠÍ AKCE
            </p>
        </div>
        <hr>
      </section>

    <div v-if="upcomingEvents && upcomingEvents.length > 0" class="section pt-3 has-text-center">
      <EventMedia v-for="(event, index) in upcomingEvents" :key="index + '-event'" :event="event"/>

      <div class="has-text-centered pt-4">
          <RouterLink :to="{name: 'program'}" class="">
            <button class="button is-link is-outlined is-small">
              Další akce
            </button>
          </RouterLink>
      </div>
    </div>
    <LoadingSection v-else-if="loadingEvents" :loading="true" />
    <section v-else class="hero is-medium">
      <div class="hero-body has-text-centered">
        <p class="subtitle">Momentálně nemáme naplánované žádné akce.</p>
        <p class="title">
          <i class="fa-solid fa-face-sad-tear"></i>
        </p>
      </div>
    </section>
    
    </div>
    <div class="section p-0 pb-5 is-small has-text-centered">
    </div>

  </main>

  </div>
</template>

<script>
import EventMedia from '../components/EventMedia.vue';
import LoadingSection from '../components/LoadingSection.vue';
import Carousel from '../components/Carousel.vue';

export default {

  components: { EventMedia, LoadingSection, Carousel },

  inject: ['events', 'loadingEvents'],

  computed: {

    upcomingEvents() {
      const nextDay = new Date();
      nextDay.setHours(23, 59, 0);
      const upcoming = this.events
        .filter(event => event.datetime)
        .filter(event => new Date(event.datetime) > nextDay)
        .filter(event => new Date(event.datetime) > nextDay);

      // SHOW ONLY NEXT N EVENTS
      const n = 3;
      if (upcoming.length > n) {
        upcoming.length = n;
      }
      upcoming.sort((a, b) => a.datetime > b.datetime)
      return upcoming;
    }

  },

}
</script>
