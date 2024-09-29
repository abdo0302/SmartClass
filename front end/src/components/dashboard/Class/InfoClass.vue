<script setup>
// Import from external libraries
import store from '@/store/stor';
import { computed, defineEmits,watch ,ref} from 'vue';
// Import local components
import AlertMessage from '../Alerts/AlertMessage.vue';
import AddEleve from '../Alerts/AddEleve.vue';

  const emit = defineEmits(['messageToParent']);
  const elevsClass=computed(()=>store.getters.getelevsClass);
  const Class=computed(()=>store.getters.getClass);    
  const CardShow = ref(false);
  const message = ref(false);
  const Message=computed(()=>store.getters.getMessage);

  function sendMessage() {
  // Émettre l'événement avec un message
  emit('messageToParent', false);
}

// Function Close Card
function handleMessage(msg) {
  message.value = msg;
}

// Function Show Card Ajouter elelve
const showAlert=()=>{
   message.value=true
}

const formatDate=(dateString)=> {
      // Créez un objet Date à partir de la chaîne de date
      const date = new Date(dateString);

      // Utilisez toLocaleDateString pour formater la date en AAAA-MM-JJ
      return date.toLocaleDateString('fr-CA'); // 'fr-CA' formate la date en 'yyyy-mm-dd'
    }

    // Function Show Alert Message et delete Eleve
 const showCardShow=(id_eleve)=>{
   CardShow.value=true
   store.commit('setMessage','');
   store.dispatch('deleteEleve',id_eleve);
   store.dispatch('getClasses');
   store.dispatch('getElevs',Class.value.id)
   
}   

 // Watch the message state to Close Alert Message
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
        <div class="bg-white p-9 relative rounded-lg flex flex-col w-1/2 max-md:w-full mx-9 h-96">
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
              <!-- loding start -->
               <div v-if="elevsClass==''" class="flex justify-center"><img  class="animate-spin" src="../../../assets/img/pngwing.com (12).png" alt=""></div>
                 <!-- loding end -->
                 <div v-else-if="elevsClass=='Aucun'" class="flex justify-center"><img  class="w-64" src="../../../assets/img/animated_emty.gif" alt=""></div>
                 <!-- table -->
            <div v-else class="flex flex-col w-full mt-4 gap-1">
                <div class="flex bg-blue-100 py-1 px-3 justify-between items-center rounded-md">
                    <div class="w-2/5 text-sm font-semibold">Name</div>
                    <div class="w-2/5 text-sm font-semibold max-md:hidden">Email</div>
                    <div class="w-2/5 text-sm font-semibold ml-5 max-md:hidden">Date de creation</div>
                    <div class="w-2/5 text-center max-md:text-start text-sm font-semibold">Actes</div>
                </div>
                <div class="max-h-60 overflow-y-auto flex flex-col gap-2 mt-2">
                    <div v-for="elevClass in elevsClass" :key="elevClass.id" class="flex w-full bg-white px-2 items-center">
                       <div class="w-2/5 text-sm flex">{{ elevClass.name }}</div>
                       <div class="w-2/5 text-sm -ml-7 max-md:hidden">{{ elevClass.email }}</div>
                       <div class="w-2/5 text-sm flex justify-center max-md:hidden">{{ formatDate(elevClass.created_at) }}</div>
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