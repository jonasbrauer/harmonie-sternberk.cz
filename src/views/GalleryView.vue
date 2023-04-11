<template>
<div id="top" class="container">
  <Breadcrumbs :crumbs="crumbs"/>
  
  <div class="section gallery-container">
    <div class="columns is-mobile px-5 mb-4">
      <div v-for="(col, index) in galleryRows" :key="index + 'gallery-col'"
          class="column p-0 m-0"
      >
        <div v-for="(image, j) in col" :key="j + image" class="notloaded-background">
          <!-- <img class="easeload" :src="image" onload="this.style.opacity=1"> -->
          <GalleryTile :source="image" />
        </div>
      </div>
    </div>
    <div class="has-text-centered">
        <button v-if="!maxShowed" v-on:click="showMore" class="button is-small">
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

  <section class="hero mb-5 gallery-container">
    <div class="hero-body py-0">
      <p class="title is-4">
        Video
      </p>
      <p class="subtitle is-6">
        Další videa můžete shlédnout na našem
        <a href="https://www.youtube.com/channel/UCkTMDhD8DZdeOrE5NJttvFQ" target="_blank">
        Youtube kanále
        </a>.
      </p>
    </div>
  </section>

  <section class="section gallery-container pb-0 pt-0" v-for="(videoUrl, index) in videos" :key="'video' + videoUrl + index">
    <figure class="image is-16by9">
      <iframe class="has-ratio" width="560" height="315"
        :src="videoUrl"
        title="YouTube video player"
        frameborder="0"
        allow="encrypted-media; gyroscope;"
        allowfullscreen
      ></iframe>
    </figure>

  </section>

  <section aria-hidden="true" class="section"/>

</div>
</template>

<script>
import Breadcrumbs from '../components/Breadcrumbs.vue'
import GalleryComponent from '../components/GalleryComponent.vue'
import GalleryTile from '../components/GalleryTile.vue'
import axios from 'axios';

export default {

  components: { Breadcrumbs, GalleryComponent, GalleryTile },

  data() {
    return {
      crumbs: [
          ['home', 'Domů'], ['orchestr', 'Orchestr']
      ],

      galleryLoading: false,
      galleryError: false,
      // main gallery always shown
      latest: [],
      // Hide away the rest in case of more photos (deeper in the directory structure).
      // todo: display in a seprate collapsible component.
      gallery: {},

      colCount: 3,
      showImages: true,
      galleryRows: [],
      showedRows: 3, // Show only this number of gallery rows. Extendible/colapsible on click.
      maxShowed: false,

      videos: [
        'https://www.youtube-nocookie.com/embed/y1ssCVafLEY',
        'https://www.youtube-nocookie.com/embed/12-7QGw0gdA',
        'https://www.youtube-nocookie.com/embed/fj7J4YRx4i8',
      ],

      crumbs: [
          ['home', 'Domů'], ['orchestr', 'Orchestr'], ['gallery', 'Galerie']
      ]
    }
  },

  watch: {
    colCount: function(newVal, oldVal) {
      this.setCurDirAsRows();
    },
    showedRows: function(newVal, oldVal) {
      this.setCurDirAsRows();
    }
  },

  methods: {
    
    getGallery() {
      this.galleryLoading = true;
      axios.get('/php/gallery.php')
         .then(res => {
           if (res.data['gallery']['.']) {
             this.latest = res.data['gallery']['.'];
             delete res.data['.'];
           }
           this.gallery = res.data.gallery;
           this.setCurDirAsRows()
           this.galleryError = false;
           this.galleryLoading = false;
          })
         .catch(err => {
           this.galleryError = true;
           this.galleryLoading = false;
          })
    },
    setCurDirAsRows() {
      // Splits this.latest into this.colCount number of columns
      this.showImages = false;
      var win = window,
      doc = document,
      docElem = doc.documentElement,
      body = doc.getElementsByTagName('body')[0],
      x = win.innerWidth || docElem.clientWidth || body.clientWidth,
      y = win.innerHeight|| docElem.clientHeight|| body.clientHeight;

      this.galleryRows = [];
      for(var c = 0; c < this.colCount; c++) {
        this.galleryRows[c] = [];
      }

      const galleryLength = this.latest.length;
      // 'round' the photos count so that there is equal count in each column
      const trimIndex = galleryLength - (galleryLength % this.colCount) || galleryLength;
      // count rows and trim the rest depending on the 'showed rows' var
      var row = 0;
      for (var i = 0; i < trimIndex; i++) {
        if (i % this.colCount == 0) {
          row++;
        }
        if (row > this.showedRows) {
          return
        }
        this.galleryRows[i % this.colCount].push(this.latest[i])
      }
    },

    showMore() {
      const maxRows = (this.latest.length - (this.latest.length % this.colCount)) / this.colCount;
      this.showedRows += 2;
      if (this.showedRows >= maxRows) {
        this.maxShowed = true;
      }
    },

    computeRowCount(event) {
      // Recalculate on resize the number of items on a single row
      // on mobile: 2, otherwise 3
      if (event.target && event.target.window && event.target.window.innerWidth) {
        const width = event.target.window.innerWidth;
        if (width < 500) {
          this.colCount = 2;
        } else {
          this.colCount = 3;
        }
      }
    }

  },

  created() {
    this.getGallery();
  },
  mounted() {
    if (window.innerWidth < 500) {
      this.colCount = 2;
    } else {
      this.colCount = 3;
    }
    window.addEventListener('resize', this.computeRowCount);
  },

  unmounted() {
    window.removeEventListener('resize', this.computeRowCount);
  }

}
</script>

<style>
.notloaded-background {
  /* Show a nice gradient underneath the images - better  loading transition */
  margin: 1px;
  padding: 0px;
  background: rgb(255,255,255);
  background: linear-gradient(52deg, rgba(255,255,255,1) 0%, rgba(227,227,236,1) 100%);
}

.gallery-container {
  margin-left: 5em;
  margin-right: 5em;
  padding-bottom: 0.5em;
  margin-bottom: 1em;
}

@media only screen and (max-width: 700px) {
  .gallery-container {
    margin-left: 0em;
    margin-right: 0em;
  }
}

</style>