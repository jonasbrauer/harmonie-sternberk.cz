<template>
    <div class="date-box has-text-centered">
        <h1 class="title mb-1" style="font-family: serif;">{{ day }}</h1>
        <p class="">{{ month }}</p>
        <p class="">{{ year }}</p>
    </div>
</template>

<script>
export default {
    props: {
        date: Date|String,
    },

    data() {
        return {
            day: '?',
            month: '???',
            year: '????',

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
            // const options = {month: 'long', day: 'numeric'}
            this.day = tpmDate.getDate();
            this.month = this.months[tpmDate.getMonth()];
            this.year = tpmDate.getUTCFullYear();
            this.hour = tpmDate.getHours();
        }
    }
}
</script>

<style>
.date-box {
    min-width: 6em;

    padding: 0.5em;
    margin-left: 0em;
    margin-right: 1em;

    border: 1px solid #bbbbbb;
}

.day-number {
    font-size: 2em;
    font-weight: 25px;
}
</style>