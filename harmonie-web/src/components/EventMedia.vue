<template>
<div class="is-flex is-justify-content-center my-1">
<article class="event-media media is-flex is-align-items-center">
    
    <DateTile :date="event && event.datetime"/>

    <div>
    <p>
        <h1>{{ event && event.title }}</h1>
        <h2 v-if="event && event.subtitle">{{ event.subtitle }}</h2>
        <small>
            <span class="icon is-small mr-1"><i class="fa-regular fa-clock"></i></span>{{ time }}
        </small>
        <h4 v-if="event && event.location">
            <span class="icon is-small mr-1"><i class="fa-solid fa-location-dot"></i></span>{{ event.location }}
        </h4>
            
    </p>
    <nav class="level is-mobile">
        <div class="level-left">
        <a v-if="event && event.facebook" class="level-item mr-4" :href="event.facebook" target="_blank">
            <span class="icon is-small">
                <i class="fa-brands fa-facebook"></i>
            </span>
        </a>
        <a class="level-item" v-on:click="like">
            <span class="icon is-small"><i class="fas fa-heart"></i></span>
            <span class="ml-1">{{ (event && event.likes) || 0 }}</span>
        </a>
        </div>
    </nav>
    </div>
</article>
</div>
</template>

<script>
import DateTile from './DateTile.vue'
import axios from 'axios'

export default {

    data() {
        return {
            like_disabled: false,
        }
    },

    components: { DateTile, },
    props: ['event'],

    computed: {
        time() {
            const datetime = new Date(this.event.datetime);
            return datetime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
    },

    methods: {
        like() {
            if (this.like_disabled) {
                return;
            }
            axios.post("/php/like.php", { event_id: this.event.id })
                 .then(res => {
                this.event.likes = res.data.likes;
            }).finally(() => {
                this.like_disabled = true;
            })
        }
    }

}
</script>

<style scoped>

h1 {
    font-size: x-large;
}

.event-media {
    width: 50%;
    position: relative;
    margin-right: 0;
}

@media only screen and (max-width: 800px) {
    .event-media {
        width: 50vw;
    }
}

@media only screen and (max-width: 500px) {
    .event-media {
        width: 90%;
    }
}

@media only screen and (max-width: 400px) {
    .event-media {
        width: 100%;
    }
}

</style>