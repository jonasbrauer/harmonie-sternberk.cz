<template>
  <div class="pt-2" style="border-bottom: 1px solid #cccccc">
  
  <nav class="level m-2 mb-0">
    
    <div class="level-left">
        <div class="level-item">
          <DatetimeTile :date="event.date" :isEvent="event.type === 'concert'"/>
        </div>
    </div>

    <div class="level-item icon-box">
      <span v-if="event.type === 'concert'" class="icon has-text-primary mr-2">
        <i class="fa-solid fa-music"></i>
      </span>
      <span v-else class="icon mr-2" style="max-height: 0px"/>
    </div>

    <div class="level-item has-text-centered-mobile">
      <div style="width: 100%">
        <p class="title is-5">{{ event.title }}</p>
        <p class="heading">{{ event.place }}</p>
      </div>
    </div>

    <div v-if="event.details" class="level-right">
      <div class="level-item">
        <a v-on:click="showDetails=!showDetails" class="has-text-dark">
          více
          <span
            v-if="event.type === 'concert'"
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
    </div>

  </nav>

  <transition>
    <article v-if="event.details && showDetails" class="message mb-3">
      <div class="message-body">
        <p>{{ event.details }}</p>
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
    max-width: 3em
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