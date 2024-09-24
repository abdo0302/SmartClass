<script setup>
import { reactive, onMounted, computed,ref } from 'vue'; // Importing reactive from Vue
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import store from '@/store/stor';

const event = computed(() => store.getters.getevents);
const IsSession=ref('Choisissez la Class')
const getEvents=()=>{
   store.commit('setevents','');
   store.dispatch('getEvents',IsSession.value);
   
}
// Define calendar options as a reactive object
const calendarOptions = reactive({
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  initialView: 'timeGridWeek',
  editable: true,
  selectable: true,
  slotMinTime: '08:00:00', 
  slotMaxTime: '24:00:00', 
  allDaySlot: false, 
  firstDay: 0,  
  headerToolbar: {
    left: 'prev,next', 
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay' 
  },
  timeZone: 'GMT+01:00',
  events: event,
  eventClick: (info) => {
    store.dispatch('deletEvents', info.event.title);
    store.dispatch('getEvents',IsSession.value);
  },
});

onMounted(() => {
  store.dispatch('getClasses');
});
const checkScreenSize=()=>{
  if (window.innerWidth <= 640 ) {
    store.commit('setTitleDashbord','Home')
  }
}

window.addEventListener('resize', checkScreenSize);


const lesClasses = computed(() => store.getters.getClasses);


</script>

<template>
  <div class="bg-slate-100">
    <div class="relative bg-white mx-8 mt-5 mb-7 p-5 rounded-2xl shadow-lg">
      <div class="flex justify-center pb-2">
          <select @change="getEvents" v-model="IsSession" class="border-2 border-slate-400 py-1 px-5 rounded-lg" name="" id="">
            <option selected disabled hidden>Choisissez la Class</option>
            <option v-for="lesClasse in lesClasses.Classes" :key="lesClasse.id" :value="lesClasse.id">{{ lesClasse.name }}</option>
         </select>
      </div>
      
      <!-- Binding calendarOptions correctly using :options -->
      <FullCalendar v-if="IsSession!=='Choisissez la Class'" :options="calendarOptions"/>
    </div>
  </div>
</template>
