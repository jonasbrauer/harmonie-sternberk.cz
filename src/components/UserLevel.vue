<template>
  <div class="columns is-mobile px-2" style="border-bottom: solid 1px #ccc">
    <div class="column">
      <div class="columns">

        <div v-if="!user.validated" class="column is-2">
          <button class="button is-rounded is-small has-text-success" @click="$emit('validate')">
            <span class="icon mr-1">
              <i class="fa-solid fa-circle-check"></i>
            </span>
            potvrdit
          </button>
        </div>

        <div class="column">
          <h2 :class="{
            'is-size-6': true,
            'has-text-primary': user.role === 'admin',
            'has-text-danger': !user.validated
            }"
          >
            <span class="icon">
            <i v-if="!user.validated" class="fa-solid fa-lock"></i>              
            <i v-else-if="user.role === 'member'" class="fa-solid fa-user"></i>
            <i v-else-if="user.role === 'admin'" class="fa-solid fa-user-gear"></i>
            <i v-else class="fa-solid fa-question"></i>
          </span>
          {{ user.username }}  
          </h2>
          
        </div>

        <div class="column">{{ user.email }}</div>
      </div>
    </div>

    <DeleteButton @delete="$emit('delete', user.username)" @edit="$emit('edit')" />

  </div>
</template>

<script>
import DeleteButton from "./DeleteButton.vue";

export default {

  props: ['user'],

  components: { DeleteButton },

  data() {
    return {
      deleteConfirm: false,
    }
  }

}
</script>

<style>

</style>