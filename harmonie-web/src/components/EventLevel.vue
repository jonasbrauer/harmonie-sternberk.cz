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
    
    <DeleteButton @delete="$emit('delete', event.id)" @edit="$emit('edit')" />

  </div>
</template>

<script>
import DatetimeSimple from "./DatetimeSimple.vue"
import DeleteButton from "./DeleteButton.vue";

export default {

  props: ['event'],

  components: { DatetimeSimple, DeleteButton },

  data() {
    return {
      deleteConfirm: false,
    }
  }

}
</script>

<style>

</style>