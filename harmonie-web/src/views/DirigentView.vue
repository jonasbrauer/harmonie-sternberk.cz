<template>
<div class="container">

  <Breadcrumbs :crumbs="crumbs"/>

  <div class="columns is-centered" style="margin: 0px">
    <div class="column is-one-fifth is-flex is-justify-content-center">
      <figure class="image">
        <img class="is-rounded" src="/photos/web/dirigent.jpg" style="border: solid; border-radius: 50%; border-width: 1px; border-color: #ccc">
      </figure>
    </div>
    <div class="column is-half px-5">
      <h1 class="title mb-3" style="height: fit-content; border-bottom: solid 1px #ccc;">Petr Ciba</h1>
         <h6 style="height: fit-content;">
         Ředitel ZUŠ Šternberk<br>
         Dirigent Harmonie Šternberk,<br>
         Moravia Brass Bandu<br>
         a dechového orchestru Haná Uničov<br>
         </h6>
    </div>
  </div>

  <div class="section content pt-3">
    <p>Narozen 9.září 1963 ve Šternberku
      Ředitel ZUŠ Šternberk
      Dirigent Harmonie Šternberk,
      Moravia Brass Bandu
      a dechového orchestru Haná Uničov
    </p>

    <ul>
      <li>1970 – 1981 Základní umělecká škola Šternberk</li>
      <li>1977 – 1981 Gymnázium Šternberk</li>
      <li>1981 – 1985 Lékařská fakulta UP Olomouc</li>
      <li>1988 – 1994 Konzervatoř Brno, obor lesní roh</li>
    </ul>

    <p>
      Absolvoval dirigentské kurzy v ČR i zahraničí, studoval
      obory Hudební kultura – sbormistrovství na Pedagogické
      a Muzikologie na Filozofické fakultě UP Olomouc.
    </p>

    <p>
      V roce 2009 a 2010 se zúčastnil vzdělávací konference Midwest
       Clinic v americkém Chicagu, která byla zaměřena na problematiku 
       repertoáru, metodiky práce a dirigování symfonických dechových orchestrů.
    </p>
  </div>

</div>
</template>

<script>
import Breadcrumbs from '../components/Breadcrumbs.vue'
export default {

    components: { Breadcrumbs },

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