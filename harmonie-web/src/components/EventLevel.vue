<template>
  <div class="columns is-mobile px-2" style="border-bottom: solid 1px #ccc">
    <div class="column">
      <div class="columns">
        <div class="column">
          <h2 :class="{title: true, 'is-5': true, 'has-text-primary': event.type === 'concert'}">
            <span v-if="event.type === 'concert' || event.type === 'tour'" class="icon">
            <i v-if="event.type === 'concert'" class="fa-solid fa-music"></i>
            <i v-else-if="event.type === 'tour'" class="fa-solid fa-plane-departure"></i>
          </span>
          {{ event.title }}
          </h2>
          <h3 v-if="event.subtitle" class="title is-6">{{event.subtitle}}</h3>
          <h3 v-if="event.location" class="title is-6">{{event.location}}</h3>
        </div>
        <div v-if="event.datetime" class="column">
          <DatetimeSimple :datetime="event.datetime"/>
          <span v-if="event.datetime_end">do<DatetimeSimple :datetime="event.datetime_end"/></span>
        </div>
      </div>
    </div>
    
    <div class="column is-2">      
      <transition name="slide-fade" mode="out-in">
        
        <div v-if="!deleteConfirm" class="columns">
          <div class="column p-1">
          <button class="button is-fullwidth" @click="$emit('edit')">
            <span class="icon">
              <i class="fa-solid fa-pen"></i>
            </span>
          </button>
        </div>
        <div class="column p-1">
          <button v-if="!deleteConfirm" class="button is-danger is-light is-fullwidth" @click="deleteConfirm = !deleteConfirm">
            <span class="icon">
              <i class="fa-solid fa-trash"></i>
            </span>
          </button>
        </div>
        </div> <!-- END COLUMNS -->

        <div v-else class="columns">
          <div class="column p-1">
            <button class="button is-danger is-fullwidth is-light" @click="$emit('delete', event.id)">
              <span class="icon">
                <i class="fa-solid fa-trash"></i>
              </span>
            </button>
          </div>
          <div class="column p-1">
            <button class="button is-link is-fullwidth is-light" @click="deleteConfirm = !deleteConfirm">
              <span class="icon">
                <i class="fa-solid fa-ban"></i>
              </span>
            </button>
          </div>
        </div><!-- END COLUMNS -->

      </transition>
    </div>

  </div>
</template>

<script>
import DatetimeSimple from '../components/DatetimeSimple.vue'


export default {

  props: ['event'],

  components: { DatetimeSimple },

  data() {
    return {
      deleteConfirm: false,
    }
  }

}
</script>

<style>

</style>