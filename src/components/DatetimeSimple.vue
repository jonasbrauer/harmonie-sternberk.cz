<template>
  <h3 class="is-6">
    {{weekday}} {{ date.getDate() }}.{{ date.getMonth() + 1 }}. {{ date.getUTCFullYear() }}
    <span v-if="date.getHours() !== 0">v {{ date.getHours()}}h</span>
  </h3>
</template>

<script>
export default {
  props: ['datetime'],

  data() {
    return {
      days: [
          'ne',
          'po',
          'út',
          'st',
          'čt',
          'pá',
          'so',
          'ne',
      ],
    }
  },

  computed: {
    date() {
      return new Date(this.datetime);
    },
    weekday() {
      return this.days[this.date.getDay()];
    }
  }
}
</script>

<style>

</style>