<template>
<div class="container pb-5 mb-5">

  <Breadcrumbs :crumbs="crumbs"/>

    <figure class="side-image">
      <img src="/photos/web/about-2.jpg"/>
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

    <div class="section content m-0 pb-5">
      <div class="columns">
        <div class="column is-4 has-text-right-tablet is-flex">
          <h2 class="is-align-self-center" style="max-height: fit-content;">
            Nejvýznamnější úspěchy Harmonie Šternberk
          </h2>
        </div>
        <div class="column">
          <ul class="mt-0">
            <li>účast na koncertu vítězů rozhlasové soutěže Concerto Bohemia 2002&nbsp;a&nbsp;2007</li>
            <li>zisk 1. místa na mezinárodním soutěžním festivale mládeže v belgickém Neerpeltu (2003 a 2005)</li>
            <li>zisk 1. místa na mezinárodní soutěži v italském Sinnai (Sardinie 2011)</li>
            <li>absolutní vítěz mezinárodních soutěží v Praze (2007, 2009, 2017) a Ostravě (2007, 2013, 2015, 2019, 2021)</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="level is-mobile px-2 mb-1">
      <GalleryTile class="p-1" source="/photos/web/about-3.jpg" />
      <GalleryTile class="p-1" source="/photos/web/about-4.jpg" />
      <GalleryTile class="p-1" source="/photos/web/about-1.jpg" />
    </div>
    <p class="has-text-centered mb-2">
      <small class="help">
        <RouterLink :to="{name: 'gallery'}">
          Prohlédnout celou galerii
          <span class="icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
        </RouterLink>
      </small>
    </p>


    <p class="section py-0 mt-3">
      V současné době má orchestr přibližně <strong>60 členů</strong> a je složen
      především ze současných i bývalých žáků základní umělecké 
      školy ve Šternberku a studentů středních a vysokých škol.
      Orchestr každoročně absolvuje řadu koncertních vystoupení a 
      pravidelně se účastní soutěží, festivalů a přehlídek dechových 
      orchestrů v České republice i v zahraničí.
    </p>
    
    <div class="section content m-0">

      <div class="columns">
        <div class="column is-4 has-text-right-tablet is-flex">
          <h2 class="is-align-self-center" style="max-height: fit-content;">
            Vrcholy dosavadní činnosti orchestru
          </h2>
        </div>
        <div class="column">
          <ul class="mt-0 hr-bottom pb-3">
            <li>účast na 10. ročníku Japonského hudebního festivalu mládeže ve městě Shizuoka v roce 2006</li>
            <li>trojnásobná účast na světové soutěži WMC (World Music Contest) v holandském Kerkrade v letech 2009, 2013 a 2017</li>
          </ul>
          <ul class="mt-0">
            <li>Cena města Šternberka 2013</li>
            <li>Cena Olomouckého kraje za přínos v oblasti kultury 2014</li>
          </ul>
        </div>
      </div>

    </div>

</div>
</template>

<script>
import Breadcrumbs from '../components/Breadcrumbs.vue'
import Timeline from '../components/Timeline.vue'
import GalleryTile from '../components/GalleryTile.vue'

export default {

    components: { Breadcrumbs, Timeline, GalleryTile },

    data() {
        return {
            crumbs: [
                ['home', 'Domů'], ['orchestr', 'Orchestr']
            ]
        }
    },

}
</script>
<style>
.content li {
  list-style: none;
}

.content li:before {
  content: '\203a';
  font-family: 'FontAwesome';
  float: left;
  margin-left: -1.2em;
}

</style>
