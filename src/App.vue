<script>
import { computed } from "vue";

import { RouterLink, RouterView } from "vue-router";
import Navbar from "./components/Navbar.vue";
import FooterMain from "./components/FooterMain.vue";

import { fetchPublicEvents, fetchUser } from "./api";

export default {
  components: { Navbar, FooterMain },

  data() {
    return {
      user: null,
      events: [],
      loadingEvents: false,
      configHeaders: { Accept: "application/json" },
    };
  },

  provide() {
    // Expose for the entire application scope:
    return {
      user: computed(() => this.user), // logged-in user
      events: computed(() => this.events), // queried events
      loadingEvents: computed(() => this.loadingEvents),
    };
  },

  created() {
    this.getUser();
    this.getEvents();
  },

  methods: {
    getUser() {
      fetchUser()
        .then((res) => (this.user = res.data))
        .catch((err) => (this.user = null));
    },

    getEvents() {
      this.loadingEvents = true;
      fetchPublicEvents()
        .then((res) => {
          this.events = res.data;
        })
        .catch((err) => {
          this.events = [];
          console.error(err);
        })
        .finally(() => {
          console.info("finally...");
          this.loadingEvents = false;
        });
    },
  },
};
</script>

<template>
  <div class="page-wrapper">
    <Navbar @logout="user = null" @login="getUser" />

    <hr class="mt-0 mb-0" />

    <RouterView />

    <div class="footers">
      <FooterMain />
    </div>
  </div>
</template>

<style>
@import "./assets/mystyles.css";
@import "./assets/overrides.css";
@import url('https://fonts.googleapis.com/css2?family=Karma:wght@300;400;500;600;700&display=swap');

body {
  position: absolute;
  inset: 0;
}

#app {
  height: 100%;
  font-family: "Catamaran", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.page-wrapper {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.footers {
  margin-top: auto;
  padding-top: 5rem;
}

.hr-bottom {
  border-bottom: solid 1px #ddd;
}

.events-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding-inline: 1rem;
}

.page {
  /* instead of broken container */
  width: min(100%, 1280px);
  margin-inline: auto;
}

/*
  TRANSITIONS
  for the entire app are located here
*/

.v-enter-active {
  transition: all 0.3s ease-out;
}

.v-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.v-enter-from,
.v-leave-to {
  transform: translateY(10px);
  opacity: 0;
}

/* --- */

.slide-fade-leave-active,
.slide-fade-enter-active {
  transition: all 0.2s ease-out;
}

.slide-fade-enter-from {
  transform: translateX(-30px);
  opacity: 0;
}
.slide-fade-leave-to {
  transform: translateX(30px);
  opacity: 0;
}
</style>
