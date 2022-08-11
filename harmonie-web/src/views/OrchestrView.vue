<template>
<div class="container">

  <Breadcrumbs :crumbs="crumbs"/>

  <section class="section pt-0">
    <span class="title is-5">HARMONIE ŠTERNBERK</span> je studentský dechový
    orchestr, který byl založen krátce po vzniku hudební školy ve Šternberku. 
    První vystoupení tohoto orchestru se uskutečnilo v r. 1957. Postupně se za
     dirigentským pultem vystřídali Jaroslav Chytil (zakladatel orchestru), 
     Rostislav Aberle a Stanislav Rolek. Nynějším hlavním dirigentem je 
     Petr Ciba, který převzal orchestr v r. 1999 a s jehož příchodem došlo 
     k navýšení počtu členů orchestru a k výrazné obměně repertoáru. 
     V současné době má orchestr více jak 60 členů a 
     je složen především ze současných i bývalých žáků základní umělecké
      školy ve Šternberku a studentů středních a vysokých škol olomouckého regionu.
  </section>

  <!-- TODO: members section -->

  <section class="section pt-0">
    <figure class="image">
      <img src="/photos/web/carousel-2.jpg" style="border-radius: 5px"/>
    </figure>
  </section>

</div>
</template>

<script>
import Breadcrumbs from '../components/Breadcrumbs.vue'
export default {

    components: { Breadcrumbs },

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

</style>