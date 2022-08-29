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
        <span v-if="!newEventForm" class="level is-mobile level-left">
          <p @click="eventTemplate = null; newEventForm = !newEventForm" class="button mr-1">
            <span class="icon mr-1">
              <i class="fa-solid fa-plus"></i>
            </span>Nová událost
          </p>
          <p @click="eventTemplate = rehearsalTemplate; newEventForm = !newEventForm" class="button mr-1">
            <span class="icon mr-1">
              <i class="fa-solid fa-plus"></i>
            </span>Nová zkouška
          </p>
        </span>
        <!-- toggleable NEW-EVENT form -->
        <EventForm
          v-else
          :inputEvent="eventTemplate"
          :error="eventFormError"
          @cancel="newEventForm = !newEventForm"
          @submit="postEvent"
        />
        <p v-if="newEventError" class="help is-danger">{{ newEventError }}</p>
      </transition>

      <hr>

      <transition name="slide-fade" mode="out-in">
      <div v-if="events && events.length > 0">
      <div class="column" v-for="(event, key) in events" :key="key + 'admineventrow' + event.id">
        <EventLevel :event=event @delete="deleteEvent(event.id)" @edit="clickEditEvent(event.id)"/>
         <transition  name="slide-fade" mode="out-in">
        <EventForm
          v-if="event.id === edittingEvent"
          :inputEvent="event"
          :error="eventFormError"
          @cancel="edittingEvent = null"
          @submit="postEvent"
        />
        </transition>
      </div>
      </div>
      <LoadingSection v-else :loading="true" />
      </transition>
      
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
      <UserForm
        v-else admin="true"
        :roles="roles"
        :allUsers="users"
        :error="userFormError"
        @cancel="newUserForm = !newUserForm, userFormError = false"
        @submit="postUser"
      />
      <p v-if="newUserError" class="help is-danger">{{ newUserError }}</p>
      </transition>

      <hr>

      <transition name="slide-fade" mode="out-in">
      <div v-if="users && users.length > 0">
      <div class="column" v-for="(user, key) in unvalidatedUsers" :key="key + 'admin' + user.username">
        <UserLevel :user=user @validate="validateUser(user)" @delete="deleteUser(user.id)" @edit="clickEditUser(user.username)" />

        <transition  name="slide-fade" mode="out-in">
        <UserForm
          v-if="user.username === edittingUser"
          admin="true"
          :inputUser="user"
          :roles="roles"
          :allUsers="users"
          :error="userFormError"
          @cancel="edittingUser = null, userFormError = false"
          @submit="postUser"
        />
        </transition>
      </div>
      </div>
      <LoadingSection v-else :loading="true" />
      </transition><!-- END unvalidated users -->

      <transition name="slide-fade" mode="out-in">
      <div v-if="users && users.length > 0">
      <div class="column" v-for="(user, key) in validatedUsers" :key="key + 'admin' + user.username">
        <UserLevel :user=user @delete="deleteUser(user.id)" @edit="clickEditUser(user.username)"/>

        <transition  name="slide-fade" mode="out-in">
        <UserForm
          v-if="user.username === edittingUser"
          admin="true"
          :inputUser="user"
          :roles="roles"
          :allUsers="users"
          :error="userFormError"
          @cancel="edittingUser = null, userFormError = false"
          @submit="postUser"
        />
        </transition>
      </div>
      </div>
      </transition><!-- END validated users -->

    </section>

    <div v-if="users.length > 10" class="has-text-centered my-5">
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
import Breadcrumbs from '../components/Breadcrumbs.vue';
import UserLevel from '../components/UserLevel.vue';
import UserForm from '../components/UserForm.vue';
import RehearsalRow from '../components/RehearsalRow.vue';
import EventLevel from '../components/EventLevel.vue';
import EventForm from '../components/EventForm.vue';
import LoadingSection from '../components/LoadingSection.vue';

export default {

    components: { Breadcrumbs, UserLevel, UserForm, RehearsalRow, EventLevel, EventForm, LoadingSection },

    inject: ['user'],

    data() {
        return {
          newUserForm: false,
          userFormError: null,
          edittingUser: null,

          newEventForm: false,
          eventFormError: false,
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

    computed: {
      validatedUsers() {
        var res = this.users.filter(u => u.validated);
        res.sort((a, b) => a.username.localeCompare(b.username))
        return res;
      },
      unvalidatedUsers() {
        const res = this.users.filter(u => !u.validated);
        res.sort((a, b) => a.username.localeCompare(b.username))
        return res;
      }
    },

    created() {
      setTimeout(() => {
        if(!this.user || this.user.role != 'admin') {
          // If not logged-in: show lock message and after
          // a couple of secs reroute to home view.
          this.$router.push({name:'home'})
        }
      }, 5000);

      this.getUsers();
      this.getEvents();
    },

    methods: {
      postUser(userData) {
        if (isProxy(userData)) {
          userData = toRaw(userData);
        }
        axios.post("/php/user_create.php", userData)
             .then(res => {
               this.userFormError = null;
               this.newUserForm = false;
               this.edittingUser = null;
               this.getUsers();
              })
              .catch(err => {
               console.error(err);
               this.userFormError = "Ups, chybka se vloudila.";
             })
      },

      validateUser(userData) {
        userData.validated = true;
        this.postUser(userData);
      },

      postEvent(eventData) {
        if (isProxy(eventData)) {
          eventData = toRaw(eventData);
        }
        axios.post("/php/event_create.php", eventData)
             .then(res => {
               this.eventFormError = null;
               this.newEventForm = false;
               this.edittingEvent = null;
               this.getEvents();
              })
              .catch(err => {
               console.error(err);
               this.eventFormError = "Ups, chybka se vloudila.";
             })
      },

      deleteEvent(event_id) {
        axios.post('/php/event_delete.php', {id: event_id}) 
             .catch(err => console.error(err))
             .then(res => this.getEvents())
      },

      deleteUser(userId) {
        axios.post('/php/user_delete.php', {id: userId}) 
             .catch(err => console.error(err))
             .then(res => this.getUsers())
      },

      getUsers() {
        axios.get('/php/users_get.php')
           .catch(err => console.error(err))
           .then(res => {
             this.users = res.data;
             this.roles = [... new Set(this.users.map(u => u.role))];
            })
      },

      getEvents() {
        axios.get('/php/events_get.php')
          .catch(err => console.error(err))
          .then(res => {
            this.events = res.data;
          })
      },

      clickEditUser(username) {
        this.userFormError = false;
        this.newUserForm = false;
        if (this.edittingUser === username) {
          this.edittingUser = null;
        } else {
          this.edittingUser = username
        }
      },

      clickEditEvent(eventId) {
        this.eventFormError = false;
        this.newEventForm = false;
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