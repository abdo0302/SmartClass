<script setup>
import AddEvents from '../Alerts/AddEvents.vue';
import { reactive,onMounted, computed,ref } from 'vue'; // Importing reactive from Vue
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import store from '@/store/stor';
const event=computed(()=>store.getters.getevents);

const alert=ref(false)
function handleMessage(msg) {
  alert.value = msg;
}

const start=ref('');
const end=ref('');

// Define calendar options as a reactive object
const calendarOptions = reactive({
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  editable: true,
  selectable: true,
  events:event,
  select: (info) => {
    
    alert.value=true;
    start.value=''
    end.value=''
    start.value=info.startStr;
    end.value=info.endStr;
  },
  eventClick: (info) => {
    store.dispatch('deletEvents',info.event.title);
    calendarOptions.events.pop();
  },
});
onMounted(()=>{
  store.dispatch('getEvents');
});

function handlTitle(msg){
  calendarOptions.events.push({
      title: msg,
      start: start.value,
      end: end.value,
    });
    const event={
          title: msg.value,
          start: start.value,
          end: end.value,
       }
    store.dispatch('addEvents',event)
}
</script>

<template>
    <div class="bg-slate-100">
        <div class="bg-white mx-8 mt-5 mb-7 p-5 rounded-2xl shadow-lg">
           <!-- Binding calendarOptions correctly using :options -->
           <FullCalendar :options="calendarOptions"/>
       </div>
    </div>
    <AddEvents v-if="alert==true" @messageToParent="handleMessage" @message2ToParent="handlTitle"/>
</template>
