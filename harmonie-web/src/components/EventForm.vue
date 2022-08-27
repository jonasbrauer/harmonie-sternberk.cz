<template>
  <div>

    <!-- TITLE -->
    <div class="field">
      <label class="label">Název</label>
      <div class="control has-icons-left has-icons-right">
        <input
          v-model="event.title"
          :class="{ input:true, 'is-danger': !event.title, 'is-success': event.title }"
          type="text" placeholder="název"
        >
        <span class="icon is-small is-left">
          <i class="fa-solid fa-heading"></i>
        </span>
        <span class="icon is-small is-right">
          <i v-if="!event.title" class="fas fa-exclamation-triangle"></i>
          <i v-else class="fas fa-check"></i>
        </span>
      </div>
      <p v-if="!event.title" class="help is-danger">Zadej název</p>
    </div>

    <!-- SUBTITLE -->
    <div class="field">
      <label class="label">Podnadpis</label>
      <div class="control has-icons-right">
        <input class="input" v-model="event.subtitle" type="text" placeholder="podnadpis">
      </div>
    </div>

    <!-- LINK -->
    <div class="field">
      <label class="label">Odkaz</label>
      <div class="control has-icons-left">
        <input class="input" v-model="event.link" type="text" placeholder="odkaz na událost">
        <span class="icon is-small is-left">
          <i class="fa-solid fa-link"></i>
        </span>
      </div>
    </div>

    <!-- Facebook link -->
    <div class="field">
      <label class="label">Facbooková událost</label>
      <div class="control has-icons-left">
        <input class="input" v-model="event.facebook" type="url" placeholder="odkaz na facebook event">
        <span class="icon is-small is-left">
          <i class="fa-brands fa-facebook-f"></i>
        </span>
      </div>
    </div>

    <!-- Facebook link -->
    <div class="field">
      <label class="label">Místo</label>
      <div class="control has-icons-left">
        <input class="input" v-model="event.location" type="url" placeholder="místo události">
        <span class="icon is-small is-left">
          <i class="fa-regular fa-map"></i>
        </span>
      </div>
    </div>


    <!-- Event start datetime -->
    <label class="label">Začátek události</label>
    <div class="field is-grouped">
      <div class="control has-icons-left is-expanded">
        <input @input="parseDatetime" :class="{input: true, 'is-danger': !timeStart}" v-model="timeStart" type="time">
        <span class="icon is-small is-left">
          <i class="fa-regular fa-clock"></i>
        </span>
      </div>
      <div class="control has-icons-left is-expanded">
        <input @input="parseDatetime" :class="{input: true, 'is-danger': !dateStart}" v-model="dateStart" type="date">
        <span class="icon is-small is-left">
          <i class="fa-solid fa-calendar"></i>
        </span>
      </div>
    </div>

    <label class="checkbox">
      <input type="checkbox" v-model="hasEndDate">
      Událost na více dní
    </label>

    <!-- Event end datetime -->
    <transition name="slide-fade" mode="out-in">
    <div v-if="hasEndDate">

    <label class="label">Konec události</label>
    <div class="field is-grouped">
      <div class="control has-icons-left is-expanded">
        <input @input="parseDatetimeEnd" :class="{input: true, 'is-danger': !timeEnd}" v-model="timeEnd" type="time">
        <span class="icon is-small is-left">
          <i class="fa-regular fa-clock"></i>
        </span>
      </div>
      <div class="control has-icons-left is-expanded">
        <input @input="parseDatetimeEnd" :class="{input: true, 'is-danger': !dateEnd}" v-model="dateEnd" type="date">
        <span class="icon is-small is-left">
          <i class="fa-solid fa-calendar"></i>
        </span>
      </div>
    </div>

    </div>
    </transition>

    <!-- TYPE -->
    <div class="field mt-5">
      <label class="label">Typ události</label>
      <div class="control">
        <div class="select">
          <select v-model="event.type">
            <option value="concert">Koncert</option>
            <option value="rehearsal">Zkouška</option>
            <option value="tour">Zájezd</option>
            <!-- <option v-for="(role, key) in roles" :key="'user-form-' + key" :value="role">{{ roleMapping[role] || role }}</option> -->
          </select>
        </div>
        <p class="help">Koncert je veřejná událost, ostatní typy vidí pouze členové orchestru - po přihlášení.</p>
      </div>
    </div>

    <!-- INFO -->
    <div class="field">
      <label class="label">Pokyny k události</label>
      <div class="control">
        <textarea v-model="event.info" class="textarea" placeholder="Pokyny k akci"></textarea>
      </div>
    </div>

    <div class="field is-grouped">
      <div class="control">
        <button 
          :disabled="!event.title || !event.datetime || !event.type"
          @click="$emit('submit', event)"
          class="button is-link"
        >Odeslat</button>
      </div>
      <div class="control">
        <button @click="$emit('cancel')" class="button is-link is-light">Zrušit</button>
      </div>
    </div>

  </div>
</template>

<script>
export default {

  props: ['inputEvent'],

  data() {
    return {

      passwordsDontMatch: true,
      invalidUsername: "Zadej jméno",
      invalidPassword: "Zadej heslo",
      invalidEmail: false,

      hasEndDate: false,
      timeStart: null,
      timeEnd: null,
      dateStart: null,
      dateEnd: null,
      event: {

      },

      typeMapping: {
        'concert': 'Koncert',
        'rehearsal': 'Zkouška',
        'tour': 'Zájezd',
      }
    }
  },

  watch: {
    hasEndDate: function(val, oldVal) {
      this.parseDatetimeEnd()
    }
  },

  methods: {

    cancel() {
      this.$emit("cancel");
    },

    submit() {
      this.$emit("submit", this.event);
    },

    parseDatetime(){
      if (!this.timeStart || !this.dateStart) {
        this.event.datetime = null;
        return
      }
      this.event.datetime = `${this.dateStart} ${this.timeStart}`
    },

    parseDatetimeEnd(){
      if (!this.timeEnd || !this.dateEnd || !this.hasEndDate) {
        this.event.datetime_end = null;
      } else {
        this.event.datetime_end = `${this.dateEnd} ${this.timeEnd}`
      }
    }

  },

  created() {
    if (this.inputEvent) {
      this.event = { ... this.inputEvent }
      if (this.inputEvent.datetime) {
        const split = this.inputEvent.datetime.split(" ");
        this.dateStart = split[0];
        var timeString = split[1];
        if(timeString.split(":").length > 2) {
          const timeSplit = timeString.split(":");
          timeString = `${timeSplit[0]}:${timeSplit[1]}`;
        }
        this.timeStart = timeString;
      }
      if (this.inputEvent.datetime_end) {
        this.hasEndDate = true;
        const split = this.inputEvent.datetime_end.split(" ");
        this.dateEnd = split[0];
        // Trim seconds
        var timeString = split[1];
        if(timeString.split(":").length > 2) {
          const timeSplit = timeString.split(":");
          timeString = `${timeSplit[0]}:${timeSplit[1]}`;
        }
        this.timeEnd = timeString;
      }
    }
  }
}
</script>

<style>

</style>