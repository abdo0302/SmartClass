<script setup>
import store from '@/store/stor';
import AlertMessage from './AlertMessage.vue';
  import { defineEmits ,ref ,watch ,computed } from 'vue';
  const emit = defineEmits(['messageToParent']);
  function sendMessage() {
  // Émettre l'événement avec un message
  emit('messageToParent', false);
}
const messageShow=ref(false)
const Note={
  title: '',
  priority:'',
  color:'#b1baba'
}
const addNote=()=>{
  messageShow.value=true
  store.dispatch('addNote',Note);
  store.dispatch('getNotes');
}

const Message=computed(()=>store.getters.getMessage);
  watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
      messageShow.value=false
    },1500);
  }
}); 
</script>
<template>
    <div class="bg-black/60 w-full h-screen fixed top-0 left-0 z-50 flex justify-center items-center">
       <div class="relative bg-white p-4 rounded-lg w-1/2 flex flex-col gap-4" >
        <i @click="sendMessage" class="fa-solid fa-x absolute top-2 left-2 hover:bg-slate-300 p-2 rounded-full"></i>
        <h3 class="text-center text-xl font-semibold">Ajouter une Note</h3>
        <div class="flex gap-5 p-4">
            <textarea v-model="Note.title" class="border-2 border-slate-500 rounded-md w-4/5" name="" id=""></textarea>
            <select v-model="Note.priority" class="border-2 border-slate-500 rounded-lg h-fit p-2" name="" id="">
                <option value="" selected disabled hidden>Choisissez la priorité</option>
                <option value="urgen">Urgen</option>
                <option value="Important">Important</option>
                <option value="non urgent">Non Urgent</option>
            </select>
        </div>
        <div class="flex gap-3">
          <label for="">Choisissez la Color</label>
          <input v-model="Note.color" type="color" id="favcolor" name="favcolor" value="#b1baba">
        </div>
         <div class="flex justify-center">
            <button @click="addNote" class="bg-blue-600 text-white py-1.5 px-4 rounded-lg">créer</button>
         </div>
       </div>
    </div>
    <AlertMessage v-if="messageShow==true"/>
</template>