<template>
<div class="is-flex is-justify-content-center my-1">
<article class="event-media media is-flex is-align-items-center">
    
    <DateTile :date="event && event.datetime"/>

    <div>
    <p >
        <small>{{ event && event.datetime && new Date(event.datetime).getHours() }}:00</small>
        <span v-if="event && event.location"> - {{ event.location }}</span>
        <br>
        <strong class="is-size-5">{{ event && event.title }}</strong>
        <br>
        <span>{{ event && event.subtitle }}</span>
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

<style>
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