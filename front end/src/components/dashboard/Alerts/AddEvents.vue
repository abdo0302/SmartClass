<script setup>
import { defineEmits, ref } from 'vue';
  const emit = defineEmits(['messageToParent']);
  function sendMessage() {
  // Émettre l'événement avec un message
  emit('messageToParent', false);
}
const title=ref('');

function sendTitle(){
    emit('message2ToParent', title);
    sendMessage()
}
</script>
<template>
    <div class="bg-black/60 w-full h-screen fixed top-0 left-0 z-50 flex justify-center items-center">
        <div class="relative p-6 pt-9 bg-white flex flex-col w-1/4 gap-8 items-center rounded-xl">
            <i @click="sendMessage" class="fa-solid fa-x absolute top-2 left-2 text-sm hover:bg-slate-300 w-5 h-5 flex justify-center items-center rounded-full"></i>
            <input v-model="title" class="w-full border-2 border-slate-400 p-1 rounded-md" type="text" name="" id="" placeholder="Ajouter un titre">
            <button @click="sendTitle" class="bg-blue-500 text-white w-fit py-2 px-6 rounded-lg">Enregistrer</button>
        </div>
    </div>
</template>