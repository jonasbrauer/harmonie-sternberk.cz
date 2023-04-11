<template>
  <div class="timeline">
    <ul>
        <li
          v-for="item in items" :key="item" 
          class="level is-mobile mb-0"
        >
          <div v-if="Number(item.bullet)" class="bullet">
            {{ item.bullet }}
          </div>
          <a
            v-else-if="item.bullet"
            @click="item.show = !item.show"
            :class="{bullet: true, circle:true, active:item.show}">
            <span class="icon" :style="'color:' + ( item.bullet.color || 'gray')">
              <i :class="item.bullet ? item.bullet.icon : 'fa-solid fa-music'"></i>
            </span>
          </a>
          <transition name="fast-out">
          <div v-show="item.show && !Number(item.bullet)" class="description  m-4 p-2" style="border: 1px solid #bbb">
            <div class="level is-mobile mb-3">
            <h3 class="level-left">
                {{ item.date }} {{ item.title }}
            </h3>
              <a @click="item.show = false" class="tag is-small is-delete level-right"></a>
            </div>
            <h4>{{ item.text }}</h4>
          </div>
          </transition>

        </li>

    </ul>
  </div>  


</template>

<script>
export default {
  data() {
    return {
      active: -1,
      items: [
        {
          bullet: '2015',
        },
        {
          bullet: {color: 'gold', icon: 'fa-solid fa-trophy'},
          date: '23.11.2015',
          title: 'Ostrava',
          text: `mezinárodní soutěž velkých dechových orchestrů: zlaté pásmo s vyznamenáním, vítěz kategorie, absolutní vítěz soutěže`,
        },

        {
          bullet: '2011',
        },
        {
          bullet: {color: 'gold', icon: 'fa-solid fa-trophy'},
          date: '2011, Sinnai',
          text: `zisk 1. místa na mezinárodní soutěži v italském Sinnai (Sardinie)`,
        },
        {
          bullet: {color: '#cd7f32', icon: 'fa-solid fa-trophy'},
          date: '17.11. 2007, Praha',
          text: `vítězství v rozhlasové soutěži Concerto Bohemia 2007 a 
                účast na koncertu vítězů ve velkém sále pražského Žofína (17.11.2007)
                v přímém televizním a rozhlasovém přenosu`,
        },
        {
          date: '17.11. 2007, Praha',
          text: `vítězství v rozhlasové soutěži Concerto Bohemia 2007 a 
                účast na koncertu vítězů ve velkém sále pražského Žofína (17.11.2007)
                v přímém televizním a rozhlasovém přenosu`,
        },
        {
          date: '17.11. 2007, Praha',
          text: `vítězství v rozhlasové soutěži Concerto Bohemia 2007 a 
                účast na koncertu vítězů ve velkém sále pražského Žofína (17.11.2007)
                v přímém televizním a rozhlasovém přenosu`,
        },
        {
          date: '17.11. 2007, Praha',
          text: `vítězství v rozhlasové soutěži Concerto Bohemia 2007 a 
                účast na koncertu vítězů ve velkém sále pražského Žofína (17.11.2007)
                v přímém televizním a rozhlasovém přenosu`,
        },
        {
          date: '17.11. 2007, Praha',
          text: `vítězství v rozhlasové soutěži Concerto Bohemia 2007 a 
                účast na koncertu vítězů ve velkém sále pražského Žofína (17.11.2007)
                v přímém televizním a rozhlasovém přenosu`,
        },
        {
          date: '17.11. 2007, Praha',
          text: `vítězství v rozhlasové soutěži Concerto Bohemia 2007 a 
                účast na koncertu vítězů ve velkém sále pražského Žofína (17.11.2007)
                v přímém televizním a rozhlasovém přenosu`,
        },
        {
          date: '17.11. 2007, Praha',
          
        },
        {
          bullet: '2007',
        },
        {
          bullet: {color: 'gold', icon: 'fa-solid fa-trophy'},
          date: '17.11. 2007',
          title: 'Praha',
          text: `vítězství v rozhlasové soutěži Concerto Bohemia 2007 a 
                účast na koncertu vítězů ve velkém sále pražského Žofína (17.11.2007)
                v přímém televizním a rozhlasovém přenosu`,
        },
        {
          bullet: {color: 'gold', icon: 'fa-solid fa-trophy'},
          date: '2007',
          title: 'Ostrava',
          text: `Absolutní vítěz mezinárodní soutěže v Ostrave.`,
        },
        {
          bullet: '2005',
        },
        {
          bullet: {color: 'gold', icon: 'fa-solid fa-trophy'},
          date: '2005',
          title: 'Neerpelt',
          text: `Zisk 1. místa na mezinárodním soutěžním festivale mládeže v belgickém Neerpeltu.`,
        },
        {
          bullet: '2003',
        },
        {
          bullet: {color: 'gold', icon: 'fa-solid fa-trophy'},
          date: '2003',
          title: 'Neerpelt',
          text: `Zisk 1. místa na mezinárodním soutěžním festivale mládeže v belgickém Neerpeltu.`,
        },
      ]
    }
  },

}
</script>

<style>

.fast-out-enter-active {
  transition: all 0.3s ease-out;
}

.fast-out-leave-active {
  transition: all 0.05s;
}

.fast-out-enter-from {
  transform: translateX(-30px);
  opacity: 0;
}
.fast-out-leave-to {
  transform: translateX(30px);
  opacity: 0;
}
</style>