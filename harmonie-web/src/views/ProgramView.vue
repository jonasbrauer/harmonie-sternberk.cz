<template>
<div class="container pb-5">
    
    <Breadcrumbs :crumbs="crumbs"></Breadcrumbs>
    
    <div class="px-5 has-text-">
        <h3 class="subtitle has-text-centered">Nadcházející akce</h3>
        <EventMedia v-for="(event, index) in upcomingEvents" :key="index + '-event'" :event="event" class="my-4"/>
    </div>

    <transition name="fade" mode="out-in">
    <div v-if="!showOlder" class="pt-5 mt-5 has-text-centered">
        <a v-on:click="showOlder=!showOlder" class="button is-rounded">
            minulé akce
            <span class="icon ml-1">
                <i class="fa-solid fa-chevron-down"></i>
            </span>
        </a>
    </div>
    <div v-else>

        <hr>
            <div class="px-5">
            <h3 v-on:click="showOlder=!showOlder" class="subtitle has-text-centered">
                Minulé akce              
                <a class="icon ml-1" style="color: #ccc;">
                    <i class="fa-solid fa-circle-chevron-up"></i>
                </a>  
            </h3>
            <EventMedia v-for="(event, index) in previousEvents" :key="index + '-event'" :event="event" class="my-4"/>
            </div>
    </div>
    </transition>

</div>
</template>

<script>
import Breadcrumbs from '../components/Breadcrumbs.vue'
import EventMedia from '../components/EventMedia.vue';

export default {

    components: { Breadcrumbs, EventMedia },

    inject: ['events'],

    computed: {

      upcomingEvents() {
        const zero = new Date();
        zero.setHours(0, 0, 0);
        return this.events
          .filter(event => event.datetime)
          .filter(event => new Date(event.datetime) > zero)
          .sort((a, b) => a.datetime > b.datetime)

      },

      previousEvents() {
      const zero = new Date();
      zero.setHours(0, 0, 0);
      return this.events
        .filter(event => event.datetime)
        .filter(event => new Date(event.datetime) < zero)
      }

    },

    data() {
        return {

            showOlder: false,

            crumbs: [
                ['home', 'Domů'], ['program', 'Program']
            ],

        }
        
    },

}
</script>

<style>

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

</style>