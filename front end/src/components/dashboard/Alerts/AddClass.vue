<script setup>
  import { ref ,watch , computed} from 'vue';
  import { useStore } from 'vuex';
  const store = useStore();
  import { defineEmits } from 'vue';
  import AlertMessage from './AlertMessage.vue';
  const emit = defineEmits(['messageToParent']);
  function sendMessage() {
  // Émettre l'événement avec un message
  emit('messageToParent', false);
}
const Showmessage=ref(false)

const NameClass=ref('');
const addClass=()=>{
    store.commit('setMessage','')
    store.dispatch('addClass',NameClass.value);
    Showmessage.value=true;
}
const message=computed(()=>store.getters.getMessage);
watch(message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
      Showmessage.value=false;
      store.commit('setMessage','');
      sendMessage();
      store.dispatch('getClasses');
    },1500);
  }
});
</script>
<template>
    <div class="bg-black/60 w-full h-screen fixed top-0 left-0 z-50 flex justify-center items-center">
        <div class="bg-white p-5 rounded-xl flex flex-col w-1/3 max-md:w-full mx-8 h-1/3 items-center justify-between relative">
            <i @click="sendMessage" class="fa-solid fa-x absolute top-2 left-2 hover:bg-slate-300 p-2 rounded-full"></i>
            <span class="text-xl font-semibold">Ajouter une classe</span>
            <input v-model="NameClass" type="text" class="border-2 border-slate-300 rounded-md py-1 px-2 shadow-sm shadow-slate-400 bg-slate-100" placeholder="Name de Class">
            <button @click="addClass" class="bg-blue-600 text-white py-1.5 px-4 rounded-md shadow-md shadow-slate-400 hover:shadow-none">créer</button>
        </div>
    </div>
    <AlertMessage v-if="Showmessage"/>
</template>