<template>
<div class="is-flex is-justify-content-center my-1">
<article class="event-media media is-flex is-align-items-center">
    
    <DateTile :date="event && event.datetime" class="event-media-date"/>

    <div class="event-media-content">
        <!-- <div class="event-media-top">
            <small>
                <span class="icon is-small"><i class="fa-regular fa-clock"></i></span>
                {{ time }}
            </small>
            <a v-on:click="like" style="margin-left: auto;">
                <span class="icon is-small"><i class="fas fa-heart"></i></span>
                <span class="ml-1">{{ (event && event.likes) || 0 }}</span>
            </a>
            <a v-if="event && event.facebook" :href="event.facebook" target="_blank">
                <span class="icon is-small"><i class="fa-brands fa-facebook"></i></span>
            </a>
        </div> -->
        <h1>{{ event && event.title }}</h1>
        <h2 v-if="event && event.subtitle">{{ event.subtitle }}</h2>
        <div class="mt-2">
            <h4 v-if="event && event.location">
                <span class="icon is-small mr-1"><i class="fa-solid fa-location-dot"></i></span>{{ event.location }}
            </h4>
            <div class="event-media-top">
                <h4>
                    <span class="icon is-small mr-1"><i class="fa-regular fa-clock"></i></span>{{ time }}
                </h4>
                <a v-on:click="like" style="margin-left: auto;">
                    <span class="icon is-small"><i class="fas fa-heart"></i></span>
                    <span class="ml-1">{{ (event && event.likes) || 0 }}</span>
                </a>
                <a v-if="event && event.facebook" :href="event.facebook" target="_blank">
                    <span class="icon is-small"><i class="fa-brands fa-facebook"></i></span>
                </a>
            </div>
        </div>

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
            return `${datetime.getHours().toString().padStart(2, '0')}:${datetime.getMinutes().toString().padStart(2, '0')}`
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

h4 {
    color: #526168;
}

.event-media {
    width: min(100%, 600px);
    position: relative;
    margin-right: 0;
    padding: 1.5rem 1rem;
    border-radius: .5rem;
    box-shadow: 3px 3px 10px #27475b2a;
}

.event-media-date {
    align-self: flex-start;
}

.event-media-top {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: .5rem;
    padding-right: 1rem;
}

.event-media-content {
    display: flex;
    flex-direction: column;
    width: 100%;
    padding-left: .8rem;
    border-left: 1px solid #27475b6c;
}

h1 {
    font-size: 1.5rem;
    line-height: 100%;
}

/* @media only screen and (max-width: 800px) {
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
} */

</style>