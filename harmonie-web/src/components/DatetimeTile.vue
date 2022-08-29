<template>
    <div :class="{
        'datetime-box': true,
        'has-text-centered': true,
        'red': isEvent,
        'green': !isEvent,
    }">
        <h1 class="title is-4 mb-1">{{ day }}. {{ month }}</h1>
        <p class="">{{ weekday }} <small>v</small> {{ hour }}:00</p>
    </div>
</template>

<script>
export default {
    props: {
        date: Date|String,
        isEvent: Boolean
    },

    data() {
        return {
            weekday: null,
            hour: null,
            // show invalid input as question marks
            day: '?',
            month: '???',
            year: '????',

            days: [
                'neděle',
                'pondělí',
                'úterý',
                'středa',
                'čtvrtek',
                'pátek',
                'sobota',
                'neděle',
            ],

            months: [
                'leden',
                'únor',
                'březen',
                'duben',
                'květen',
                'červen',
                'červenec',
                'srpen',
                'září',
                'říjen',
                'listopad',
                'prosinec',
            ],
        }
    },

    created() {
        if (this.date) {
            var tpmDate = this.date;
            if (typeof this.date === 'string' || this.date instanceof String) {
                tpmDate = new Date(this.date);
            }
            this.weekday = this.days[tpmDate.getDay()];
            this.day = tpmDate.getDate();
            this.month = this.months[tpmDate.getMonth()];
            this.year = tpmDate.getUTCFullYear();
            this.hour = tpmDate.getHours();
        }
    }
}
</script>

<style>
.datetime-box {
    min-width: 6em;
    padding: 0.5em;
    margin-left: 0em;
    margin-right: 0em;
}

.day-number {
    font-size: 2em;
    font-weight: 25px;
}
</style>