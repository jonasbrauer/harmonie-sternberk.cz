import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import OrchestrView from '../views/OrchestrView.vue'
import DirigentView from '../views/DirigentView.vue'
import ProgramView from '../views/ProgramView.vue'
import GalleryView from '../views/GalleryView.vue'
import NotFoundView from '../views/NotFoundView.vue'
import MembersView from '../views/MembersView.vue'
import AdminView from '../views/AdminView.vue'
import RequestAccessView from  '../views/RequestAccessView.vue'


const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/program',
      name: 'program',
      component: ProgramView,
    },
    {
      path: '/dirigent',
      name: 'dirigent',
      component: DirigentView,
    },
    {
      path: '/orchestr',
      name: 'orchestr',
      component: OrchestrView,
    },
    {
      path: '/galerie',
      name: 'gallery',
      component: GalleryView,
    },
    {
      path: '/procleny',
      name: 'members',
      component: MembersView,
    },
    {
      path: '/administrace',
      name: 'admin',
      component: AdminView,
    },
    {
      path: '/novyclen',
      name: 'newmember',
      component: RequestAccessView,
    },
    { 
      path: '/:catchAll(.*)', 
      component: NotFoundView,
      name: 'NotFound'
    },

  ]
})

export default router
