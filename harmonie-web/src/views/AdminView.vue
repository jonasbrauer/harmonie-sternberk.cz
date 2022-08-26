<template>
<div class="container">

  <Breadcrumbs :crumbs="crumbs"/>
  <div ref="top" v-if="user && user.role === 'admin'">

    <!-- EVENTS -->
    <section class="section pt-2">
      <h1 class="title is-4">Správa událostí
        <small class="ml-2 is-size-6">
          <a @click="scrollInto('members')">
            Členové
            <span class="icon mr-1">
              <i class="fa-solid fa-arrow-down"></i>
            </span>
          </a>
        </small>
      </h1>
      <transition  name="slide-fade" mode="out-in">
        <!-- buttons -->
        <span v-if="!newEventForm">
          <p @click="eventTemplate = null; newEventForm = !newEventForm" class="button mr-1">
            <span class="icon mr-1">
              <i class="fa-solid fa-plus"></i>
            </span>Přidat událost
          </p>
          <p @click="eventTemplate = rehearsalTemplate; newEventForm = !newEventForm" class="button mr-1">
            <span class="icon mr-1">
              <i class="fa-solid fa-plus"></i>
            </span>Přidat zkoušku
          </p>
        </span>
        <!-- togglable form -->
        <EventForm v-else :inputEvent="eventTemplate" @cancel="newEventForm = !newEventForm" @submit="postEvent"/>
        <p v-if="newEventError" class="help is-danger">{{ newEventError }}</p>
      </transition>

      <hr>

      <div class="column" v-for="(event, key) in events" :key="key + 'admineventrow' + event.id">
        <EventLevel :event=event @delete="deleteEvent" @edit="clickEditEvent(event.id)"/>
         <transition  name="slide-fade" mode="out-in">
        <EventForm
          v-if="event.id === edittingEvent"
          :inputEvent="event"
          @cancel="edittingEvent = null"
          @submit="postEvent"
        />
        </transition>
      </div>
      
    </section>

    <!-- MEMBERS -->
    <section ref="members" class="section pt-2">
      <h1 class="title is-4">Správa členů
        <small class="ml-2 is-size-6">
          <a @click="scrollInto('top')">
            Události
            <span class="icon mr-1">
              <i class="fa-solid fa-arrow-up"></i>
            </span>
          </a>
        </small>
      </h1>
      <transition  name="slide-fade" mode="out-in">
      <p v-if="!newUserForm" v-on:click="newUserForm = !newUserForm" class="button">
        <span class="icon mr-1">
          <i class="fa-solid fa-plus"></i>
        </span>Přidat nového člena
      </p>
      <UserForm v-else :roles="roles" :allUsers="users" @cancel="newUserForm = !newUserForm" @submit="postUser"/>
      <p v-if="newUserError" class="help is-danger">{{ newUserError }}</p>
      </transition>

      <hr>
      <div class="column" v-for="(user, key) in users" :key="key + 'admin' + user.username">
        <UserLevel :user=user @delete="deleteUser" @edit="clickEditUser(user.username)"/>

        <transition  name="slide-fade" mode="out-in">
        <UserForm
          v-if="user.username === edittingUser"
          :inputUser="user"
          :roles="roles"
          :allUsers="users"
          @cancel="edittingUser = null"
          @submit="postUser"
        />
        </transition>
      </div>
    </section>

    <div v-if="users.length > 4" class="has-text-centered my-5">
      <small class="ml-2 is-size-6">
        <a @click="scrollInto('top')">
          Nahoru
          <span class="icon">
            <i class="fa-solid fa-arrow-up"></i>
          </span>
        </a>
      </small>
    </div>

  </div>

  <!-- Hide everything away for for unauthorized users -->
  <div v-else>

    <section class="hero is-medium has-text-centered">
      <div class="hero-body">
        <p class="title">
          <span class="icon mr-1">
            <i class="fa-solid fa-lock"></i>
          </span>
          Ups...
        </p>
        <p class="subtitle">
           Pro přístup k administraci je nutné se přihlásit jako administrátor.
        </p>
      </div>
    </section>

  </div>

</div>
</template>

<script>
import { isProxy, toRaw } from 'vue';
import axios from 'axios';
import Breadcrumbs from '../components/Breadcrumbs.vue'
import UserLevel from '../components/UserLevel.vue'
import UserForm from '../components/UserForm.vue'
import RehearsalRow from '../components/RehearsalRow.vue'
import EventLevel from '../components/EventLevel.vue'
import EventForm from '../components/EventForm.vue'

export default {

    components: { Breadcrumbs, UserLevel, UserForm, RehearsalRow, EventLevel, EventForm },

    inject: ['user'],

    data() {
        return {
          newUserForm: false,
          newUserError: null,
          edittingUser: null,

          newEventForm: false,
          newEventError: false,
          edittingEvent: null,

          events: [],
          users: [],
          roles: [],
          crumbs: [
              ['home', 'Domů'], ['admin', 'Administrace']
          ],

          eventTemplate: null,
          rehearsalTemplate: {
            title: 'Zkouška',
            location: 'sál ZUŠ Šternberk',
            type: 'rehearsal',
          }
        }
    },

    created() {
      setTimeout(() => {
        if(!this.user || this.user.role != 'admin') {
          // If not logged-in: show lock message and after
          // a couple of secs reroute to home view.
          this.$router.push({name:'home'})
        }
      }, 10000);

      this.getUsers();
      this.getEvents();
    },

    methods: {
      postUser(userData) {
        if (isProxy(userData)) {
          userData = toRaw(userData);
        }
        axios.post("/php/user_create.php", userData)
             .catch(err => this.newUserError = err.data)
             .then(res => {
               this.newUserError = null;
               this.newUserForm = false;
               this.edittingUser = null;
               this.getUsers();
              })
      },

      postEvent(eventData) {
        if (isProxy(eventData)) {
          eventData = toRaw(eventData);
        }
        axios.post("/php/event_create.php", eventData)
             .catch(err => this.newUserError = err.data)
             .then(res => {
               this.newEventError = null;
               this.newEventForm = false;
               this.edittingEvent = null;
               this.getEvents();
              })
      },

      deleteEvent(event_id) {
        axios.post('/php/event_delete.php', {id: event_id}) 
             .catch(err => {})
             .then(res => this.getEvents())
      },

      deleteUser(username) {
        axios.post('/php/user_delete.php', {username: username}) 
             .catch(err => {})
             .then(res => this.getUsers())
      },

      getUsers() {
        axios.get('/php/users_get.php')
           .then(res => {
             this.users = res.data;
             this.roles = [... new Set(this.users.map(u => u.role))];
            })
      },

      getEvents() {
        axios.get('/php/events_get.php')
           .then(res => {
             this.events = res.data;
            })
      },

      clickEditUser(username) {
        if (this.edittingUser === username) {
          this.edittingUser = null;
        } else {
          this.edittingUser = username
        }
      },

      clickEditEvent(eventId) {
        if (this.edittingEvent === eventId) {
          this.edittingEvent = null;
        } else {
          this.edittingEvent = eventId
        }
      },

      scrollInto(reference) {
        this.$refs[reference].scrollIntoView({behavior: "smooth"});
      }

      
    },

}
</script>

<style>

</style>