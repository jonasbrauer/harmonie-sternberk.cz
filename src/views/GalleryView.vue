<template>
<div id="top" class="page px-1">
  <Breadcrumbs :crumbs="crumbs"/>
  
  <div class="gallery-container">
    <div class="photos-container">
      <div v-for="image in showedImages" class="column p-0 m-0">
        <GalleryTile :source="image" />
      </div>
    </div>
    <div class="has-text-centered mt-4">
        <button v-if="showedCount < latest.length" v-on:click="showMore" class="button is-small">
          <span class="icon">
            <i class="fa-solid fa-lg fa-chevron-down"></i>
          </span>
        </button>
    </div>
  </div>
  
  <!--
    # WIP
    <GalleryComponent :dir="gallery"/>
  -->

  <hr>

  <h2 class="title is-4">Video</h2>
  <p class="subtitle is-6">
    Další videa můžete shlédnout na našem
    <a href="https://www.youtube.com/channel/UCkTMDhD8DZdeOrE5NJttvFQ" target="_blank">
    Youtube kanále
    </a>.
  </p>

  <section class="gallery-container videos-container">
  <figure v-for="(videoUrl, index) in videos" :key="'video' + videoUrl + index" class="image is-16by9">
    <iframe class="has-ratio" width="560" height="315"
      :src="videoUrl"
      title="YouTube video player"
      frameborder="0"
      allow="encrypted-media; gyroscope;"
      allowfullscreen
    ></iframe>
  </figure>
  </section>

</div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import Breadcrumbs from '../components/Breadcrumbs.vue'
import GalleryComponent from '../components/GalleryComponent.vue'
import GalleryTile from '../components/GalleryTile.vue'
import axios from 'axios';

// onMounted(() => {
//   setTimeout(() => {
//     window.scrollTo({ top: 0, behavior: 'smooth' });
//   }, .5);
// })

const crumbs = [['home', 'Domů'], ['gallery', 'Galerie']];

const galleryLoading = ref(false);
const galleryError = ref(false)

// main gallery always shown
const latest = ref([]);


// Hide away the rest in case of more photos (deeper in the directory structure).
// todo: display in a seprate collapsible component.
const gallery = ref({});

const showedCount = ref(4)
if (window.innerWidth > 1200) {
  showedCount.value = 8;
} else if (window.innerWidth > 700) {
  showedCount.value = 6;
}

const videos = [
  'https://www.youtube-nocookie.com/embed/y1ssCVafLEY',
  'https://www.youtube-nocookie.com/embed/12-7QGw0gdA',
  'https://www.youtube-nocookie.com/embed/fj7J4YRx4i8',
  'https://www.youtube-nocookie.com/embed/icrXf5jaRmE?si=8ALSCWplQkzRQ6kV',
];


const showedImages = computed(() => {
  return latest.value.slice(0, showedCount.value);
});


const getGallery = () => {
  galleryLoading.value = true;
  axios.get('/php/gallery.php')
      .then(res => {
        if (res.data['gallery']['.']) {
          latest.value = res.data['gallery']['.'];
          delete res.data['.'];
        }
        gallery.value = res.data.gallery;
        galleryError.value = false;
        galleryLoading.value = false;
      })
      .catch(err => {
        galleryError.value = true;
        galleryLoading.value = false;
      })
}

getGallery();

const showMore = () => {
  showedCount.value += 8;
};
</script>

<style>
.notloaded-background {
  /* Show a nice gradient underneath the images - better  loading transition */
  margin: 1px;
  padding: 0px;
  background: rgb(255,255,255);
  background: linear-gradient(52deg, rgba(255,255,255,1) 0%, rgba(227,227,236,1) 100%);
}

.photos-container {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: .1rem;
}

@media only screen and (max-width: 700px) {
  .photos-container {
    grid-template-columns: 1fr 1fr;
  }
}

@media only screen and (min-width: 1280px) {
  .photos-container {
    grid-template-columns: 1fr 1fr 1fr 1fr;
  }
}

.videos-container {
  display: grid;
  gap: .5rem;
  grid-template-columns: 1fr 1fr;
}

@media only screen and (max-width: 960px) {
  .videos-container {
    grid-template-columns: 1fr;
  }
}

iframe {
  border-radius: .5rem;
}
</style>