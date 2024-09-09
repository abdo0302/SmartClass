<script setup>
import AddNote from '../Alerts/AddNote.vue';
import AlertMessage from '../Alerts/AlertMessage.vue';
import { ref,onMounted,computed ,watch } from 'vue';
import { useStore } from 'vuex';
const store = useStore();
const message = ref(false);
function handleMessage(msg) {
  message.value = msg;
}
const showForme=()=>{
    message.value=true;
}
const Notes=computed(()=>store.getters.getNotes)
onMounted(()=>{
    store.dispatch('getNotes');
});

const alertShow=ref(false)
const delet=(id)=>{
    store.dispatch('deletNote',id);
    store.dispatch('getNotes');
    alertShow.value=true;
}

const Message=computed(()=>store.getters.getMessage);
  watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
        alertShow.value=false
    },1500);
  }
}); 
</script>
<template>
    <div class="bg-white py-4 px-8 my-6 mx-20 rounded-xl shadow-md flex flex-col gap-5 items-center">
        <div class="flex justify-between items-center w-full">
            <span v-if="Notes!=='Aucun'" class="text-lg font-semibold">Total de Note {{ Notes.length }}</span>
            <button @click="showForme" class="bg-blue-600 text-white p-2 rounded-lg shadow-md hover:shadow-none">Ajouter Note</button>
        </div>
        <div v-if="Notes!=='Aucun'" class="w-4/5 shadow-sm flex flex-col gap-2 h-96 overflow-y-auto p-2">
            <div  v-for="Note in Notes" :key="Note.id" :style="'background-color:'+Note.color+';'" class="flex shadow-md p-4 items-center gap-3 rounded-lg border">
                <i :class="{
                            'fa-solid fa-star': true,
                            'text-red-500': Note.priority == 'urgen',
                            'text-yellow-300': Note.priority == 'Important',
                            'text-green-400': Note.priority == 'non urgent'
                            }"></i>
                <span>{{Note.title}}</span>
                <button @click="delet(Note.id)" class="bg-red-400 text-white px-4 py-1 rounded-md shadow-md hover:shadow-none ml-auto"><i class="fa-solid fa-trash"></i></button>
            </div>
        </div>
        <div v-if="Notes=='Aucun'" class="flex justify-center">
            <img class="w-1/2" src="../../../assets/img/animated_emty.gif" alt="">
        </div>
    </div>
    <AddNote v-if="message==true"  @messageToParent="handleMessage"/>
    <AlertMessage v-if="alertShow==true" />
</template>