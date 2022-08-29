<template>
<div>

  <main>
    <section
      ref="homeCarousel"
      class="banner is-flex is-justify-content-center"
      :style="'filter: grayscale(0.5); ' + carouselStyle"
      >
    <div class="has-text-centered" style="width: fit-content; height: fit-content; position: fixed; bottom:1em;">
      <div class="p-5">
          <p class="title is-4">{{ carouselText[carouselIndex][0] }}</p>
          <p class="subtitle is-6 mb-0">{{ carouselText[carouselIndex][1] }}</p>
          <div class="is-flex is-justify-content-center mt-3">
              <p v-for="(item, index) in carousel" :key="index + 'carousel'"
                 :class="{
                    circle:true,
                    'is-active': index == carouselIndex,
                    'mx-1': true
                  }"
              ></p>
            </div>
        </div>
    </div>
    </section>    

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
    <LoadingSection v-else :loading="true" />
    
    </div>
    <div class="section p-0 pb-5 is-small has-text-centered">
    </div>

  </main>

  </div>
</template>

<script>
import EventMedia from '../components/EventMedia.vue';
import LoadingSection from '../components/LoadingSection.vue';

export default {

  components: { EventMedia, LoadingSection },

  inject: ['events'],

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
      return upcoming;
    }

  },

  data() {
    return {
      carouselRunning: false,
      carouselStyle: "",
      carouselIndex: 0,
      carousel: ['/photos/web/carousel-2.jpg', '/photos/web/carousel-3.jpg', '/photos/web/carousel-1.jpg'],
      carouselText: [
        ['Harmonie Šternberk', 'symfonický dechový orchestr'],
        ['Funguje v rámci ZUŠ Šternberk'],
        [ 'Pravidelně pořádá vlastní koncerty', 'a účastní se festivalů a soutěží']
      ],

    }
  },

  methods: {

    setStyle() {
      this.carouselStyle = `background: linear-gradient(#ffffff00 50%, #000), url('${this.carousel[this.carouselIndex]}') center; background-size: cover; filter: grayscale(0.5)`
    },

    carouselStart() {
      if (!this.carouselRunning) return
      this.fadeIn(0.4)
      this.setStyle()
      setTimeout(() => {
        this.carouselIndex = (this.carouselIndex + 1) % this.carousel.length
        this.carouselStart()
      }, 8000)
    },

    fadeIn(opacity) {
      setTimeout(() => {
        if (opacity < 1) {
          if (!this.$refs.homeCarousel) {
            return
          }
          this.$refs.homeCarousel.style.opacity = opacity += 0.005
          this.fadeIn(opacity)
        }
      }, 3)
    },
  },
  
  mounted() {
    if (!this.carouselRunning) {
      this.carouselRunning = true;
      this.carouselStart();
    }
  },

  beforeUnmount() {
    this.carouselRunning = false;
  },

}
</script>

<style>

.banner p {
    color: white;
    /* Carousel text in different font? */
    /* font-family: 'Montserrat', sans-serif; */
}

.banner {
    background-position: center;

    background: linear-gradient(#ffffff00 45%, #222), url('/carousel-1.jpg'), center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;

    filter: grayscale(0.5);
    text-shadow: 3px 2px 2px #000;

    height: 600px;
}

@media only screen and (max-width: 400px) {
    .pooster {
        margin-left: 12em;
        margin-right: 12em;
    }
}


@media only screen and (max-width: 1724px) {
    .banner {
        height: 400px;
    }
}

@media only screen and (max-width: 1024px) {
    .banner {
        height: 500px;
    }
}

@media only screen and (max-width: 600px) {
    .banner {
        height: 400px;
    }
}

@media only screen and (max-width: 400px) {
    .banner {
        height: 400px;
    }
}

.circle {
  width: 10px;
  height: 10px;
  border: solid 2px #fff;
  border-radius: 0.5em;
}

.circle.is-active {
  background-color: #fff;
}

</style>
