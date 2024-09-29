<script setup>
// Import from external libraries
import { defineEmits ,computed ,onMounted, ref,watch} from 'vue';
import { useStore } from 'vuex';
// Import local components
import AlertMessage from './AlertMessage.vue';

  // Initialize the store 
  const store = useStore();
  const emit = defineEmits(['messageToParent']);

  const lesClasses=computed(()=>store.getters.getClasses);
  const MessageAlert=ref(false)
  const event={title:'', start:'', end:'', id__session:'', backgroundColor:''}
  const Message=computed(()=>store.getters.getMessage);

  function sendMessage() {
  // Émettre l'événement avec un message
  emit('messageToParent', false);
}

onMounted(() => {
  //getClasses
  store.dispatch('getClasses');
});

// Function Add Event in Calendr
const addEvent=()=>{
    store.dispatch('addEvents',event);
    store.dispatch('getEvents',event.id__session);
    MessageAlert.value=true;
}

 // Watch the message state to Close Alert Message
watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
        MessageAlert.value=false;
        store.commit('setMessage','');
        sendMessage()
    },1500);
  }
}); 
</script>
<template>
    <div class="bg-black/60 w-full h-screen fixed top-0 left-0 z-50 flex justify-center items-center">
        <div class="relative p-6 pt-9 bg-white flex flex-col w-fit gap-8 items-center rounded-xl">
            <i @click="sendMessage" class="fa-solid fa-x absolute top-2 left-2 text-sm hover:bg-slate-300 w-5 h-5 flex justify-center items-center rounded-full"></i>
            <input v-model="event.title" class="w-full border-2 border-slate-400 p-1 rounded-md" type="text" name="" id="" placeholder="Ajouter un titre">
            <div class="flex items-center gap-2"><span class="text-nowrap">Date de début</span> <input v-model="event.start" class="border-2 p-2 rounded-lg" type="datetime-local" name="" id=""></div>
            <div class="flex items-center gap-2"><span>Date de fin</span> <input v-model="event.end" class="border-2 p-2 rounded-lg" type="datetime-local" name="" id=""></div>
            <select v-model="event.id__session" name="" id="" class="border-2 border-slate-300 rounded-lg p-2">
                <option value="" selected disabled hidden>Choisissez la Class</option>
                <option class="hover:bg-slate-200 p-1 rounded-lg" v-for="lesClasse in lesClasses.Classes" :key="lesClasse.id" :value="lesClasse.id">{{ lesClasse.name }}</option>
            </select>
            <input v-model="event.backgroundColor" type="color" name="" id="" value="#BFC6C6">
            <button @click="addEvent" class="bg-blue-500 text-white w-fit py-2 px-6 rounded-lg">Enregistrer</button>
        </div>
    </div>
    <AlertMessage v-if="MessageAlert==true"/>
</template>