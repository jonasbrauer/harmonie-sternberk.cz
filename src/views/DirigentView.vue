<template>
<div class="container">

  <Breadcrumbs v-if="!hideCrumbs" :crumbs="crumbs"/>

  <div class="columns is-centered" style="margin: 0px">
    <div class="column is-one-fifth is-flex is-justify-content-center">
      <figure class="image">
        <img class="is-rounded" src="/photos/web/dirigent.jpg" style="border: solid; border-radius: 50%; border-width: 1px; border-color: #ccc">
      </figure>
    </div>
    <div class="column is-half px-5">
      <h1 class="title mb-3" style="height: fit-content; border-bottom: solid 1px #ccc;">Petr Ciba</h1>
         <p>vystudoval hru na lesní roh na 
      Konzervatoři Brno a poté působil jako pedagog 
      dechových žesťových nástrojů (Brno, M. Beroun,
       Šternberk). V roce 1999 se stal ředitelem Základní 
       umělecké školy ve Šternberku a současně 
       také dirigentem symfonického dechového orchestru 
       Harmonie Šternberk.
    </p>
    </div>
  </div>

  <div class="section content pt-3">
    <p>Další hudební aktivity:
      <ul>
        <li>2014 – 2018 Předseda Svazu dechových orchestrů ČR</li>	
        <li>od 2012 Člen poroty mezinárodní soutěže dechových orchestrů v polském Rybniku</li>
        <li>2009 – 2013 Studium sbormistrovství a muzikologie (Univerzita Palackého Olomouc)</li>
        <li>od 2009 Umělecký vedoucí a dirigent městského dechového orchestru Haná Uničov</li>
        <li>2008 – 2018 Zakladatel, umělecký vedoucí a dirigent orchestru Moravia Brass Band</li>
        <li>2001 – 2012 Vzdělávací projekty: Mid Europe Schladming (Rakousko) a Midwest Clinic  Chicago (USA, 2009 a 2010)</li>
      </ul>
    </p>

  </div>

</div>
</template>

<script>
import Breadcrumbs from '../components/Breadcrumbs.vue'
export default {

    components: { Breadcrumbs },

    props: {
      hideCrumbs: {
        type: Boolean,
        default: false
      }
    },

    data() {
        return {
            crumbs: [
                ['home', 'Domů'], ['orchestr', 'Orchestr'], ['dirigent', 'Dirigent']
            ]
        }
    },

}
</script>

<style>

</style>