<script setup>
import { reactive, computed } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import store from '@/store/stor';
const emit = defineEmits(['messageToParent']);
function sendMessage() {
  emit('messageToParent', false);
}
const event = computed(() => store.getters.getevents);

const calendarOptions = reactive({
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  initialView: 'timeGridWeek',
  editable: false,
  selectable: false,
  slotMinTime: '08:00:00', 
  slotMaxTime: '24:00:00', 
  allDaySlot: false, 
  firstDay: 0,  
  headerToolbar: {
    left: '', 
    center: 'title',
    right: '' 
  },
  timeZone: 'GMT+01:00',
  events: event,
});
</script>
<template>
    <div class="bg-black/65 w-full h-screen fixed top-0 left-0 z-50 flex justify-center items-center">
       <div class="relative bg-white p-9 w-1/2 rounded-xl">
        <i @click="sendMessage" class="fa-solid fa-x absolute top-3 left-4 hover:bg-slate-200 w-7 h-7 rounded-full flex justify-center items-center"></i>
        <FullCalendar :options="calendarOptions"/>
      </div> 
    </div>
    
</template>