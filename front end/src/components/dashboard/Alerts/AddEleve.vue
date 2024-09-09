<script setup>
import AlertMessage from './AlertMessage.vue';
  import { defineEmits } from 'vue';
  import { ref } from 'vue';
  import { watch,computed } from 'vue';
  import { useStore } from 'vuex';
  const store = useStore();
  const emit = defineEmits(['messageToParent']);
  function sendMessage() {
  // Émettre l'événement avec un message
  emit('messageToParent', false);
}
let valueInput=ref('');
let continarIsShow=ref(false);
watch(valueInput, (newvalueInput) => {
  if (newvalueInput == '') {
    continarIsShow.value = false;
  }else{
    continarIsShow.value = true;
    store.dispatch('rechercherElevs',newvalueInput);
  }
});
const Class=computed(()=>store.getters.getClass); 
const recherchers=computed(()=>store.getters.getEleve_rechercher);
const inscrit={
  in_eleve:'',
  in_classe:''
}
const CardShow = ref(false);
const eleveSlect=(email,id_eleve,id_class)=>{
   valueInput.value=email;
   inscrit.in_classe=id_class;
   inscrit.in_eleve=id_eleve;
   store.commit('setMessage','');
   CardShow.value=true
   store.dispatch('inscritEleve',inscrit);
}

const Message=computed(()=>store.getters.getMessage);
watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
      CardShow.value=false
      sendMessage()
      store.dispatch('getElevs',inscrit.in_classe);
      store.dispatch('getClasses');
    },1500);
  }})
</script>
<template>
    <div class="bg-black/70 fixed top-0 right-0 w-full h-screen  z-50 flex justify-center items-center">
        <div class="bg-white p-5 rounded-xl flex flex-col w-1/3 h-1/2 items-center relative">
            <i @click="sendMessage" class="fa-solid fa-x absolute top-2 left-2 hover:bg-slate-300 p-2 rounded-full"></i>
            <span class="text-xl font-semibold">Ajouter une Eleve</span>
            <div class="w-full flex flex-col justify-center items-center mt-6">
                <input v-model="valueInput" type="text" class="w-4/5 block border-2 border-slate-300 rounded-md py-1 px-2 shadow-sm shadow-slate-400 bg-slate-100" placeholder="Email de Eleve">
                <div v-if="continarIsShow ==true" class="border border-slate-400 bg-slate-100 max-h-52 overflow-y-auto p-2 w-4/5 flex flex-col gap-2">
                   <span v-for="rechercher in recherchers" :key="rechercher.id" @click="eleveSlect(rechercher.email,rechercher.id,Class.id)" class="bg-slate-200 py-1 px-2 w-full block rounded-md hover:bg-slate-300">{{ rechercher.email }}</span>
                </div>  
            </div>
            
        </div>
    </div>
    <!-- Alert Message -->
     <AlertMessage v-if="CardShow==true"/>
</template>