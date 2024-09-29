<script setup>
// Import from external libraries
import { ref,onMounted,computed ,watch } from 'vue';
import { useStore } from 'vuex';
// Import local components
import AddNote from '../Alerts/AddNote.vue';
import AlertMessage from '../Alerts/AlertMessage.vue';

  // Initialize the store 
const store = useStore();

const message = ref(false);
const Notes=computed(()=>store.getters.getNotes);
const alertShow=ref(false);
const Message=computed(()=>store.getters.getMessage);

function handleMessage(msg) {
  message.value = msg;
}

const showForme=()=>{
    message.value=true;
}

onMounted(()=>{
    store.dispatch('getNotes');
});


const delet=(id)=>{
    store.dispatch('deletNote',id);
    store.dispatch('getNotes');
    alertShow.value=true;
}

  watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
        alertShow.value=false
    },1500);
  }
}); 
</script>
<template>
    <div class="bg-white py-4 px-8 my-6 mx-10 max-md:mx-5 rounded-xl shadow-md flex flex-col gap-5 items-center border-2">
        <div class="flex justify-between items-center w-full">
            <span v-if="Notes!=='Aucun' && Notes!==''" class="text-lg font-semibold">Total de 
                Tache {{ Notes.length }}</span>
            <button @click="showForme" class="bg-blue-600 text-white p-2 rounded-lg shadow-md hover:shadow-none">Ajouter 
                Tache</button>
        </div>
        <div v-if="Notes==''" class="flex justify-center mt-7"><img  class="animate-spin" src="../../../assets/img/pngwing.com (12).png" alt=""></div>
        <div v-else-if="Notes=='Aucun'" class="flex justify-center">
            <img class="w-1/2" src="../../../assets/img/animated_emty.gif" alt="">
        </div>
        <div v-else class="w-4/5 max-md:w-full shadow-sm flex flex-col gap-2 h-96 overflow-y-auto p-2">
            <div  v-for="Note in Notes" :key="Note.id" :style="'background-color:'+Note.color+';'" class="flex shadow-md p-4 items-center gap-3 rounded-lg border">
                <i :class="{
                            'fa-solid fa-star': true,
                            'text-red-500': Note.priority == 'urgen',
                            'text-yellow-300': Note.priority == 'Important',
                            'text-green-400': Note.priority == 'non urgent'
                            }"></i>
                <span class="w-4/5">{{Note.title}}</span>
                <button @click="delet(Note.id)" class="bg-red-400 text-white px-2 py-1 rounded-md shadow-md hover:shadow-none ml-auto"><i class="fa-solid fa-trash"></i></button>
            </div>
        </div>
    </div>
    <AddNote v-if="message==true"  @messageToParent="handleMessage"/>
    <AlertMessage v-if="alertShow==true" />
</template>