<template>
  <div class="pt-2" style="border-bottom: 1px solid #cccccc">
  
  <nav class="columns">

    <!-- DATE -->
    <div class="column is-flex is-align-items-center is-justify-content-center">
      <DatetimeTile :date="event.datetime" :isEvent="event.type === 'concert'"/>
      <span v-if="event.datetime_end" class="icon">
        <i class="fa-solid fa-arrow-right"></i>
      </span>
      <DatetimeTile v-if="event.datetime_end" :date="event.datetime_end" :isEvent="event.type === 'concert'"/>
    </div>

    <!-- ICON -->
    <div class="column py-0 is-1 is-flex is-align-items-center is-justify-content-center">
      <span v-if="event.type === 'concert'" class="icon has-text-primary mr-2">
        <i class="fa-solid fa-music"></i>
      </span>
      <span v-else-if="event.type === 'tour'" class="icon mr-2" style="color: #ccc">
        <i class="fa-solid fa-plane-departure"></i>
      </span>
    </div>

    <!-- TEXT -->
    <div class="column is-flex is-align-items-center has-text-centered-mobile">
      <div style="width: 100%">
        <p class="is-size-4">{{ event.title }}</p>
        <p v-if="event.subtitle" class="is-size-6">{{ event.subtitle }}</p>
        <p v-if="event.location" class="heading">{{ event.location }}</p>
      </div>
    </div>

    <!-- MORE -->
    <div class="column is-2 is-flex is-align-items-center is-justify-content-center">
      <a v-if="event.info" v-on:click="showDetails=!showDetails" class="has-text-dark">
        více
        <span
          :class="{
            icon: true,
            'mr-2': true,
            'chevron-rotate': true,
            'chevron-rotated': showDetails,
          }"
        >
          <i class="fa-solid fa-chevron-down"></i>
        </span>
      </a>
    </div>

  </nav>

  <transition>
    <article v-if="event.info && showDetails" class="message mb-3">
      <div class="message-body">
        <p>{{ event.info }}</p>
      </div>
    </article>
  </transition>

</div>
</template>

<script>
import DatetimeTile from '../components/DatetimeTile.vue'

export default {

    components: { DatetimeTile },

    props: ['event'],

    data() {
        return {
          showDetails: false,
        }
    },

}
</script>

<style>
@media only screen and (min-width: 768px) {

  .icon-box {
    max-width: 13em
  }
    
}

.chevron-rotate {
  transition: 0.2s;
}

.chevron-rotated {
  transform: rotateZ(-180deg);
}

.v-enter-active,
.v-leave-active {
  transition: all 0.2s ease-out;
}

.v-enter-from {
  transform: translateY(-100px);
  opacity: 0;
}

.v-leave-to {
  transform: translateY(-30px);
  opacity: 0;
}
</style>