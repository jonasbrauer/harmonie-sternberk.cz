<template>
  <h3 class="is-6">
    {{weekday}} {{ date.getDate() }}.{{ date.getMonth() }}. {{ date.getUTCFullYear() }}
    <span v-if="date.getHours() !== 0">v {{ date.getHours()}}h</span>
  </h3>
</template>

<script>
export default {
  props: ['datetime'],

  data() {
    return {
      date: null,
      weekday: null,
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

  created() {
    this.date = new Date(this.datetime);
    this.weekday = this.days[this.date.getDay()];
  }
}
</script>

<style>

</style>