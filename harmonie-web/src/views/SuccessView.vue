<template>
<div class="container">

  <Breadcrumbs :crumbs="crumbs"/>

  <section class="hero">
    <div class="hero-body pt-0">
      <p class="title">
        Úspěchy
      </p>
      <p class="subtitle">
        orchestru
      </p>
    </div>
  </section>

  <div class="timeline">
    <ul>      
        <li>
            <div class="box m-4">
                <h3>
                    <span class="icon" style="color:gold"><i class="fa-solid fa-trophy"></i></span>
                    23.11. 2015, Ostrava
                </h3>
                <h4>mezinárodní soutěž velkých dechových orchestrů: zlaté pásmo s vyznamenáním, vítěz kategorie, absolutní vítěz soutěže</h4>
            </div>
        </li>

        <li>
            <div class="bullet green">2015</div>
        </li>


        <li>
            <div class="box m-4">
                <h3>
                    <span class="icon" style="color:gold"><i class="fa-solid fa-trophy"></i></span>
                    6.7. 2013, Kerkrade
                </h3>
                <h4>světová soutěž WMC v holandském Kerkrade 2013: zlaté pásmo s vyznamenáním za 90,33 b. (divize 2).</h4>
            </div>
        </li>
        <li>
            <div class="box m-4">
                <h3>
                    <span class="icon" style="color:gold"><i class="fa-solid fa-trophy"></i></span>
                    28.1. 2013, Praha
                </h3>
                <h4>mezinárodní soutěž velkých dechových orchestrů Ostrava 2013: zlaté pásmo, vítěz kategorie, absolutní vítěz soutěže</h4>
            </div>
        </li>

        <li>
            <div class="bullet green">2013</div>
        </li>

        <li>
        <div class="box m-4">
            <h3>
                <span class="icon" style="color:silver"><i class="fa-solid fa-trophy"></i></span>
                13.7. 2009, Kerkrade
            </h3>
          <h4>světová soutěž WMC v holandském Kerkrade 2009: stříbrné pásmo (divize 2)</h4>
        </div>
        </li>


        <li>
            <div class="bullet green">2009</div>
        </li>

        <li>
            <div class="box m-4">
                <h3>17.11. 2007, Praha</h3>
            <h4>
                vítězství v rozhlasové soutěži Concerto Bohemia 2007 a 
                účast na koncertu vítězů ve velkém sále pražského Žofína (17.11.2007)
                v přímém televizním a rozhlasovém přenosu
            </h4>
            </div>
        </li>

        <li>
            <div class="bullet green">2007</div>
        </li>

    </ul>
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
                ['home', 'Domů'], ['orchestr', 'Orchestr'], ['success', ' Úspěchy']
            ],
            milestones: [
                // #TODO: query from db
            ],
        }
    },

}
</script>

<style>

</style>