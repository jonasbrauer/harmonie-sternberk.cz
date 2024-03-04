import axios from 'axios';


const DUMMY_USER = {
  data: {
    username: 'John Doe',
    role: 'admin'
  }
}

const nextWeek = (daysOffset) => {
  const d = new Date();
  d.setDate(d.getDate() + (daysOffset ?? 7));
  return d;
}
const DUMMY_EVENTS = {
  data: [
    {
      title: '2. ročník',
      subtitle: 'večerní open-air koncert pro milovníky filmových melodií',
      datetime: nextWeek(365),
      location: "MKZ \u0160ternberk",
    },
    {
      title: '1. ročník soutěžního festivalu Svazu dechových orchestrů ČR',
      subtitle: 'večerní open-air koncert pro milovníky filmových melodií',
      datetime: nextWeek(),
      facebook: 'https://facebook.com',
      location: "MKZ \u0160ternberk",
    },
  ]
}

export const fetchPublicEvents = async() => {
  if (import.meta.env.PROD) {
    return await axios.get('/php/events_public_get.php', { headers: this.configHeaders })
  }

  return DUMMY_EVENTS;
}


export const fetchUser = async () => {
  if (import.meta.env.PROD) {
    return await axios.get('/php/login.php', { headers: this.configHeaders })
  }

  return DUMMY_USER
}

export const login = async (credentials) => {
  if (import.meta.env.PROD) {
    await axios.post('/php/login.php', credentials);
  }

  return DUMMY_USER
}

export const logout = async () => {
  if (import.meta.env.PROD) {
    await axios.delete('/php/login.php')
  }
}