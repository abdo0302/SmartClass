<script setup>
import AddClass from '../Alerts/AddClass.vue';
import InfoClass from './InfoClass.vue';
import ChartClass from './ChartClass.vue';
import AlertMessage from '../Alerts/AlertMessage.vue';
import { ref } from 'vue';
import { onMounted,computed,watch } from 'vue';
import store from '@/store/stor';
const message = ref(false);
function handleMessage(msg) {
  message.value = msg;
}
const showAlert=()=>{
   message.value=true
}
const lesClasses=computed(()=>store.getters.getClasses);
const TotalClase=ref(0);
watch(lesClasses, (newlesClasses) => {
  TotalClase.value=newlesClasses.Classes.length
})

// chart js
onMounted(() => {
  //getClasses
  store.dispatch('getClasses');
});

const CardShow = ref(false);
function handleCardShow(msg) {
   CardShow.value = msg;
}
const showCardShow=(id)=>{
   CardShow.value=true
   store.dispatch('getElevs',id)
   store.dispatch('getClass',id)
}
const formatDate=(dateString)=> {
      // Créez un objet Date à partir de la chaîne de date
      const date = new Date(dateString);

      // Utilisez toLocaleDateString pour formater la date en AAAA-MM-JJ
      return date.toLocaleDateString('fr-CA'); // 'fr-CA' formate la date en 'yyyy-mm-dd'
    }
    //alert message
let messageShow=ref(false); 
const Message=computed(()=>store.getters.getMessage);
watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
      messageShow.value=false
    },1500);
  }
});    
  //delet class
const deleteClass=(value)=>{
     store.commit('setMessage','')
     store.dispatch('deleteClass',value)
     store.dispatch('getClasses');
     messageShow.value=true;
}   

</script>
<template>
    <div class="w-full flex gap-5 py-4 px-9">
        <!-- continar start -->
        <div class="w-full bg-white shadow-xl rounded-xl py-3 px-5">
         <!-- {{ lesClasses[0].map(element => element.name) }} -->
         
            <!-- header -->
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Les Classes</span>
                    <span class="text-xs text-slate-600">total de class {{ TotalClase }}</span>
                </div>
                <button @click="showAlert" class="bg-blue-600 text-white p-2 text-xs rounded-md h-fit shadow-md shadow-slate-400 hover:shadow-none">
                    Ajouter classe
                </button>
            </div>
            <!-- body -->
             <!-- table -->
            <div class="flex flex-col w-full mt-4 gap-1">
                <div class="flex bg-blue-100 py-1 px-3 justify-between items-center rounded-md">
                    <div class="w-2/5 text-sm font-semibold">Name</div>
                    <div class="w-2/5 text-sm font-semibold">Elèves</div>
                    <div class="w-2/5 text-sm font-semibold">Date de creation</div>
                    <div class="w-2/5 text-end mr-6 text-sm font-semibold">Actes</div>
                </div>
                <div class="h-96 overflow-y-auto flex flex-col gap-2">
                    <div v-for="(lesClasse,i) in lesClasses.Classes" :key="lesClasse.id" class="flex w-full bg-white px-2 items-center">
                       <div class="w-2/5 text-sm flex">{{ lesClasse.name }}</div>
                       <div class="w-2/5 text-sm ml-5">{{ lesClasses.eleve[i] }}</div>
                       <div class="w-2/5 text-sm">{{ formatDate(lesClasse.created_at) }}</div>
                       <div class="w-2/5 text-end flex justify-end gap-3"><button @click="showCardShow(lesClasse.id)" class="bg-orange-400 text-white px-3 rounded-md shadow-md hover:shadow-none"><i class="fa-solid fa-eye text-sm"></i></button><button @click="deleteClass(lesClasse.id)" class="bg-red-400 text-white px-3 rounded-md shadow-md hover:shadow-none"><i class="fa-solid fa-trash"></i></button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- continar end -->
         <!-- continar start -->
        <ChartClass/>
        <!-- continar end -->
    </div>
    <!-- alert add class -->
    <AddClass v-if="message"  @messageToParent="handleMessage"/>
    <!-- alert Info Class -->
     <InfoClass v-if="CardShow==true" @messageToParent="handleCardShow"/>
     <!-- alert message -->
      <AlertMessage v-if="messageShow==true"/>
</template>