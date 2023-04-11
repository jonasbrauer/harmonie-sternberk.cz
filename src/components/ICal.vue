<template>
<button
    :disabled="events.length < 1"
    @click="downloadFile"
    :class="{
        'is-small': true,
        button: true,
        'is-rounded': true,
        tag: true,
        'is-success': events.length > 0,
        'is-outlined': true
    }">
    <span class="icon mr-1">
        <i class="fa-solid fa-download"></i>
    </span>
    {{ events.length }}
</button>
</template>

<script>
import ics from 'ics';

export default {
    
    props: [ 'events' ],

    methods: {

        downloadFile() {

            // Create a Blob from the content string
            const blob = new Blob([this.generate()], { type: 'text/plain' });

            // Create a download link element
            const a = document.createElement('a');

            // Set the download link's href to the object URL of the Blob
            a.href = URL.createObjectURL(blob);

            // Set the download link's download attribute to the file name
            a.download = "calendar.ics";

            // Click the download link to start the download
            a.click();
        },

        splitDatetime(datetime) {
            const [ Y, M, tmp ] = datetime.split("-")
            const [ D, time ] = tmp.split(" ")
            const [ H, m, _ ] = time.split(":")
            return [ Y, M, D, H, m ].map(str => Number(str))
        },

        generate() {
            const { error, value } = ics .createEvents(
                this.events.map(ev => {
                    return {
                        title: ev.title,
                        description: ev.subtitle,
                        start: this.splitDatetime(ev.datetime),
                        duration: { hours: 3 },
                        location: ev.location,
                        url: "https://www.harmonie-sternberk.cz/#/procleny"
                    }
                }))
            if (error) {
                console.log(error)
                return
            }
            return value
        }

    },
}
</script>