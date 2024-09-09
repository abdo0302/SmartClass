<script setup>
import AlertMessage from '../Alerts/AlertMessage.vue';
import store from '@/store/stor';
import AddEleve from '../Alerts/AddEleve.vue';
import { computed, defineEmits,watch } from 'vue';
  const emit = defineEmits(['messageToParent']);
  function sendMessage() {
  // Émettre l'événement avec un message
  emit('messageToParent', false);
}

import { ref } from 'vue';
const message = ref(false);
function handleMessage(msg) {
  message.value = msg;
}
const showAlert=()=>{
   message.value=true
}
//get elevs Class
const elevsClass=computed(()=>store.getters.getelevsClass);
const formatDate=(dateString)=> {
      // Créez un objet Date à partir de la chaîne de date
      const date = new Date(dateString);

      // Utilisez toLocaleDateString pour formater la date en AAAA-MM-JJ
      return date.toLocaleDateString('fr-CA'); // 'fr-CA' formate la date en 'yyyy-mm-dd'
    }
  const Class=computed(()=>store.getters.getClass);    
 // card message
 const CardShow = ref(false);
 const showCardShow=(id_eleve)=>{
   CardShow.value=true
   store.commit('setMessage','');
   store.dispatch('deleteEleve',id_eleve);
   store.dispatch('getClasses');
   store.dispatch('getElevs',Class.value.id)
   
}   
const Message=computed(()=>store.getters.getMessage);
watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
      CardShow.value=false
    },1500);
  }})

</script>
<template>
    <div class="bg-black/60 w-full h-screen fixed top-0 left-0 z-40 flex justify-center items-center">
        <!-- card -->
        <div class="bg-white p-9 relative rounded-lg flex flex-col w-1/2 h-96">
         <i @click="sendMessage" class="fa-solid fa-x absolute top-2 left-2 hover:bg-slate-300 p-2 rounded-full"></i>
         <!-- headr card-->
            <div class="flex justify-between items-center">
                <!-- contenar 1 start -->
                <div class="flex flex-col">
                    <span class="text-xl font-semibold">{{ Class.name }}</span>
                </div>
                <!-- contenar 1 end -->
                 <button @click="showAlert" class="bg-blue-600 text-white p-2 text-xs rounded-md h-fit shadow-md shadow-slate-400 hover:shadow-none">Ajouter elelve</button>
            </div>
            <!-- body card -->
            <div>
                 <!-- table -->
            <div class="flex flex-col w-full mt-4 gap-1">
                <div class="flex bg-blue-100 py-1 px-3 justify-between items-center rounded-md">
                    <div class="w-2/5 text-sm font-semibold">Name</div>
                    <div class="w-2/5 text-sm font-semibold">Email</div>
                    <div class="w-2/5 text-sm font-semibold ml-5">Date de creation</div>
                    <div class="w-2/5 text-center text-sm font-semibold">Actes</div>
                </div>
                <div class="h-60 overflow-y-auto flex flex-col gap-2">
                    <div v-for="elevClass in elevsClass" :key="elevClass.id" class="flex w-full bg-white px-2 items-center">
                       <div class="w-2/5 text-sm flex">{{ elevClass.name }}</div>
                       <div class="w-2/5 text-sm -ml-7">{{ elevClass.email }}</div>
                       <div class="w-2/5 text-sm flex justify-center">{{ formatDate(elevClass.created_at) }}</div>
                       <div class="w-2/5 text-end flex justify-center"><button @click="showCardShow(elevClass.id)" class="bg-red-400 text-white px-3 rounded-md shadow-md hover:shadow-none"><i class="fa-solid fa-trash"></i></button></div>
                    </div>
                </div>
            </div>
            </div>  
        </div>
    </div>
    <!-- alert add eleve -->
     <AddEleve v-if="message"  @messageToParent="handleMessage"/>
    <!-- alert message   -->
    <AlertMessage v-if="CardShow==true"/>
</template>