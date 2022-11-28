<template>
  <section
      ref="homeCarousel"
      class="banner is-flex is-justify-content-center"
      :style="'filter: grayscale(0.5); ' + carouselStyle"
      >
    <div class="has-text-centered" style="width: fit-content; height: fit-content; position: fixed; bottom:1em;">
      <div class="p-5">
          <p class="title is-4">{{ carouselText[carouselIndex][0] }}</p>
          <p class="subtitle is-6 mb-0">{{ carouselText[carouselIndex][1] }}</p>
          <div class="is-flex is-justify-content-center mt-3">
              <a @click="prev" class="icon has-text-light mr-2">
                <i class="fa-solid fa-caret-left"></i>
              </a>
              <!-- DOTS -->
              <p v-for="(item, index) in carousel" :key="index + 'carousel'"
                 :class="{
                    circle:true,
                    'is-active': index == carouselIndex,
                    'mx-1': true
                  }"
              ></p>
              <a @click="next" class="icon has-text-light ml-2">
                <i class="fa-solid fa-caret-right"></i>
              </a>
            </div>
        </div>
    </div>
    </section>
</template>

<script>
export default {

  data() {
    return {
      carouselRunning: false,
      carouselStyle: "",
      carouselIndex: 0,
      carouselTimeoutId: null,
      preloadedPics: [],
      carousel: [
        '/photos/web/carousel-3.jpg',
        '/photos/web/carousel-1.jpg',
        '/photos/web/carousel-4.jpg',
      ],
      carouselText: [
        ['Harmonie Šternberk', 'symfonický dechový orchestr'],
        ['Harmonie Šternberk', 'symfonický dechový orchestr'],
        ['Harmonie Šternberk', 'symfonický dechový orchestr'],
      ],

    }
  },

  methods: {

    fadeIn(opacity) {
      setTimeout(() => {
        if (opacity < 1) {
          if (!this.$refs.homeCarousel) {
            return
          }
          this.$refs.homeCarousel.style.opacity = opacity += 0.005
          this.fadeIn(opacity)
        }
      }, 3)
    },

    setStyle() {
      this.carouselStyle = `background: linear-gradient(#ffffff00 50%, #000), url('${this.carousel[this.carouselIndex]}') center; background-size: cover; filter: grayscale(0.5)`
    },

    setCarousel() {
      this.fadeIn(0.7)
      this.setStyle()
    },

    next() {
      if (this.carouselTimeoutId) {
        clearTimeout(this.carouselTimeoutId);
      }
      this.carouselIndex = (this.carouselIndex + 1) % this.carousel.length
      this.carouselStart()
    },

    prev() {
      if (this.carouselTimeoutId) {
        clearTimeout(this.carouselTimeoutId);
      }
      this.carouselIndex = this.carouselIndex - 1;
      if (this.carouselIndex < 0) {
        this.carouselIndex =  this.carouselIndex + this.carousel.length;
      }
      this.carouselStart();
    },

    carouselStart() {
      if (!this.carouselRunning) return
      this.setCarousel();
      this.carouselTimeoutId = setTimeout(() => {
        this.carouselIndex = (this.carouselIndex + 1) % this.carousel.length
        this.carouselStart()
      }, 8000)
    },

    
  },

  mounted() {
    this.carousel.forEach(url => {
      const img = new Image();
      img.src = url;
      this.preloadedPics.push(img);
    })

    if (!this.carouselRunning) {
      this.carouselRunning = true;
      this.carouselStart();
    }
  },

  beforeUnmount() {
    this.carouselRunning = false;
  },

}
</script>

<style>
.banner p {
    color: white;
    /* Carousel text in different font? */
    /* font-family: 'Montserrat', sans-serif; */
}

.banner {
    background-position: center;

    background: linear-gradient(#ffffff00 45%, #222), url('/carousel-1.jpg'), center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;

    filter: grayscale(0.5);
    text-shadow: 3px 2px 2px #000;

    height: 900px;
}


@media only screen and (max-width: 1724px) {
    .banner {
        height: 600px;
    }
}

@media only screen and (max-width: 1024px) {
    .banner {
        height: 500px;
    }
}

@media only screen and (max-width: 600px) {
    .banner {
        height: 400px;
    }
}

@media only screen and (max-width: 400px) {
    .banner {
        height: 350px;
    }
}

.circle {
  width: 10px;
  height: 10px;
  border: solid 2px #fff;
  border-radius: 0.5em;
  margin-top: 7px;
}

.circle.is-active {
  background-color: #fff;
}
</style>