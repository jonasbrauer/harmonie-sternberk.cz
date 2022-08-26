<template>
  <div class="columns is-mobile px-2" style="border-bottom: solid 1px #ccc">
    <div class="column">
      <div class="columns">
        <div class="column">
          <h2 :class="{title: true, 'is-6': true, 'has-text-primary': user.role === 'admin'}">
            <span class="icon">
            <i v-if="user.role === 'member'" class="fa-solid fa-user"></i>
            <i v-else-if="user.role === 'admin'" class="fa-solid fa-user-gear"></i>
            <i v-else class="fa-solid fa-question"></i>
          </span>
          {{ user.username }}
          </h2>
        </div>
        <div class="column">{{ user.email }}</div>
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
            <button class="button is-danger is-fullwidth is-light" @click="$emit('delete', user.username)">
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
export default {
  props: ['user'],

  data() {
    return {
      deleteConfirm: false,
    }
  }

}
</script>

<style>

</style>