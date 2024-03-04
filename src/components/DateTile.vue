<template>
    <div class="date">
        <div class="digit">{{ day }}</div>
        <span>{{ month }}</span>
        <span v-if="new Date().getUTCFullYear() !== year">{{ year }}</span>
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

<style lang="css" scoped>
.date {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    /* border-right: 1px solid #27475b; */
}
.digit {
    font-size: 5rem;
    line-height: 4rem;
    font-weight: 100;
    font-family: "Karma", serif;
    width: 6.5rem;
    /* color: #27475b; */
}

span {
    font-weight: 100;
    font-size: large;
    text-transform: uppercase;
    /* color: #27475b; */
}
</style>