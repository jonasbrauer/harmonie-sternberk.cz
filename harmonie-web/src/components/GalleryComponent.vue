<template>
  <!--
    Recursively show all the images in the gallery directory structure
    # WIP
  -->
  <div>
    <h1 class="title">{{ dirKey }}</h1>
    
    <div v-if="dir['.'] && dir['.'].length != 0">
      <div v-for="path in dir['.']" :key="path">
        {{ path }}
      </div>
    </div>
    <hr>
    
    <gallery-component
      v-for="(value, key, index) in getFiltered(dir)" :key="key + '-' + index"
      :dir="value" :dirKey="key"
    />

  </div>
</template>

<script>
export default {
  props: ["dirKey", "dir"],
  name: "gallery-component",

  data() {
    return {
      currentDir: [],
      nextRoot: {},
    }
  },

  methods: {
    getFiltered(dir) {
      return Object.fromEntries(
        Object.entries(dir)
              .filter(([k,v]) => k != '.')
      )
    }
  }
}
</script>

<style>

</style>