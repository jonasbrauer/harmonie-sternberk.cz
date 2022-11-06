<template>
<div class="image-container">
  <a :href="source" target="_blank">
  <img class="easeload" :src="source" onload="this.style.opacity=1">
  </a>
</div>
</template>

<script>
export default {
  props: ['source']
}
</script>

<style>
.image-container {
  position: relative;
  width: 100%;
  height: 8em;
  overflow: hidden;
}

@media only screen and (min-width: 700px) {
  .image-container {
    height: 11em;
  }
}

.image-container img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}

.easeload{
  opacity: 0;
  -webkit-transition: all 0.8s ease; 
  -moz-transition: all 0.8s ease; 
  -ms-transition: all 0.8s ease; 
  -o-transition: all 0.8s ease; 
}
</style>