<template>
<div>

  <main>
    <Carousel />

    <div class="container mt-3">    

      <!-- <div class="poster">
        <img src="/posters/2023_05_27.jpg">
      </div> -->
          
      <h1 class="title is-4">
        <span class="icon mr-2">
          <i class="fa-solid fa-calendar"></i>
        </span>
        NEJBLIŽŠÍ AKCE
      </h1>

      <div v-if="upcomingEvents && upcomingEvents.length > 0" class="events-list">
        <EventMedia v-for="(event, index) in upcomingEvents" :key="event.datetime" :event="event" />

        <div class="has-text-centered">
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
          <p class="subtitle">Momentálně nemáme naplánované žádné akce</p>
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
        .filter(event => new Date(event.datetime) > nextDay)
        .sort((a, b) => new Date(a.datetime) - new Date(b.datetime))

      // SHOW ONLY NEXT N EVENTS
      const n = 3;
      if (upcoming.length > n) {
        upcoming.length = n;
      }
      return upcoming;
    }

  },

}
</script>
<style lang="scss" scoped>
  
.poster {
  display: grid;
  justify-items: center;

  img {
    @media screen and (min-width: 720px) {
      width: 50%;
    }
  }
}

.title {
  width: 100%;
  text-align: center;
  margin-top: 2rem;
}
</style>
