<template>
<div class="container pb-5 mb-5">

  <Breadcrumbs :crumbs="crumbs"/>

    <figure class="side-image">
      <img src="/photos/web/harmonie2.jpg"/>
    </figure>

    <div class="section py-0">
      <h1 class="is-4 title hr-bottom py-4">HARMONIE ŠTERNBERK</h1>
      <p class="py-1">
        je studentský dechový
        orchestr, který byl založen krátce po vzniku hudební školy ve 
        Šternberku - první vystoupení tohoto souboru je zaznamenáno v r. 1957.
      </p>

      <p class="py-1">
        Novodobá historie orchestru se datuje od r. 1999 s příchodem
        nynějšího dirigenta a ředitele ZUŠ Šternberk
        <RouterLink :to="{name: 'dirigent'}"><strong>Petra&nbsp;Ciby</strong></RouterLink>,
        kdy došlo k postupnému navyšování počtu členů a zásadní změně
        repertoáru, který akcentuje původní skladby či transkripce z
        oblasti moderní umělecké symfonické dechové hudby.
      </p>
    </div>

    <p class="section is-small">
      V současné době má orchestr přibližně <strong>60 členů</strong> a je složen
      především ze současných i bývalých žáků základní umělecké 
      školy ve Šternberku a studentů středních a vysokých škol.
      Orchestr každoročně absolvuje řadu koncertních vystoupení a 
      pravidelně se účastní soutěží, festivalů a přehlídek dechových 
      orchestrů v České republice i v zahraničí.
    </p>

    <div class="section py-0 content">
      <h1 class="is-5 title">Nejvýznamnější úspěchy Harmonie&nbsp;Šternberk:</h1>
      <ul class="has-text-left">
        <li>účast na koncertu vítězů rozhlasové soutěže Concerto Bohemia 2002 a 2007</li>
        <li>zisk 1. místa na mezinárodním soutěžním festivale mládeže v belgickém Neerpeltu (2003 a 2005)</li>
        <li>zisk 1. místa na mezinárodní soutěži v italském Sinnai (Sardinie 2011)</li>
        <li>absolutní vítěz mezinárodních soutěží v Praze (2007, 2009, 2017) a Ostravě (2007, 2013, 2015, 2019, 2021)</li>
      </ul>
    </div>
    
    <div class="section py-0 content">
      <h1 class="title is-5 mb-1">Vrcholy dosavadní činnosti orchestru:</h1>
      <ul class="has-text-left">
        <li>účast na 10. ročníku Japonského hudebního festivalu mládeže ve městě Shizuoka v roce 2006</li>
        <li>trojnásobná účast na světové soutěži WMC (World Music Contest) v holandském Kerkrade v letech 2009, 2013 a 2017</li>
      </ul>
    </div>

    <div class="section py-0 content">
      <h1 class="title is-5 mb-1">Další udělená ocenění Harmonii Šternberk:</h1>
      <ul class="has-text-left">
        <li>Cena města Šternberka 2013</li>
        <li>Cena Olomouckého kraje za přínos v oblasti kultury 2014</li>
      </ul>
    </div>

</div>
</template>

<script>
import Breadcrumbs from '../components/Breadcrumbs.vue'
import Timeline from '../components/Timeline.vue'

export default {

    components: { Breadcrumbs, Timeline },

    data() {
        return {
            crumbs: [
                ['home', 'Domů'], ['orchestr', 'Orchestr']
            ]
        }
    },

}
</script>
