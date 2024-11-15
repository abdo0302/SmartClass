<script setup>
// Import from external libraries
import { onMounted,computed, ref ,watch } from 'vue';
import { useStore } from 'vuex';
// Import local components
import AlertMessage from '../Alerts/AlertMessage.vue';
import AddUser from './AddUser.vue';

  // Initialize the store 
const store = useStore();

const Users = computed(() => store.getters.getUsers);
const alertShow=ref(false);
const modalAddUser=ref(false)
const Message=computed(()=>store.getters.getMessage);

onMounted(()=>{
    store.dispatch('getusers');
});

const formatDate=(dateString)=> {
    // Créez un objet Date à partir de la chaîne de date
    const date = new Date(dateString);
    // Utilisez toLocaleDateString pour formater la date en AAAA-MM-JJ
    return date.toLocaleDateString('fr-CA'); // 'fr-CA' formate la date en 'yyyy-mm-dd'
  }

 
  const deletUser=(id)=>{
    alertShow.value=true
    store.dispatch('deletUsers',id);
    store.dispatch('getusers')
  }

  
  watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
        alertShow.value=false
    },1500);
  }
}); 

//function show modale user
function showModaleUser() {
  modalAddUser.value=true
}

function handleshowModaleUser(msg) {
  modalAddUser.value = msg;
  store.dispatch('getusers')
}
</script>
<template>
  <div class="w-full h-screen -mt-24 flex justify-center items-center">
    <div class="w-4/5 max-md:w-full bg-white p-5 shadow-md rounded-xl">
        <div class="flex justify-between items-center mb-5" ><span class="text-lg font-semibold">Totle profs</span> <button @click="showModaleUser" class="bg-blue-600 py-2 px-4 rounded-md text-white shadow-md hover:shadow-none">Ajouter User</button></div>
            <!-- table -->
            <div class="flex flex-col w-full mt-4 gap-1">
                <div class="flex bg-blue-100 py-1 px-3 justify-between items-center rounded-md">
                    <div class="w-2/5 text-sm font-semibold">Name</div>
                    <div class="w-2/3 text-sm font-semibold text-center">email</div>
                    <div class="w-2/3 text-sm font-semibold text-center">phone</div>
                    <div class="w-2/5 text-sm font-semibold text-center max-md:hidden">Date de inscrire</div>
                    <div class="w-2/5 text-end text-sm font-semibold">Actes</div>
                </div>
                <div class="max-h-56 overflow-y-auto flex flex-col gap-2">
                    <div v-for="User in Users" :key="User.id" class="flex w-full bg-white px-2 items-center">
                       <div class="w-2/5 text-sm flex">{{ User.name }}</div>
                       <div class="w-2/3 text-nowrap text-sm text-center">{{ User.email }}</div>
                       <div class="w-2/3 text-nowrap text-sm text-center">{{ User.email }}</div>
                       <div class="w-2/5 text-sm text-center max-md:hidden">{{ formatDate(User.created_at) }}</div>
                       <div class="w-2/5 text-end flex justify-end gap-3"><button @click="deletUser(User.id)" class="bg-red-400 text-white px-3 rounded-md shadow-md hover:shadow-none"><i class="fa-solid fa-trash"></i></button></div>
                    </div>
                </div>
            </div>
        </div>
  </div>        
        <AlertMessage v-if="alertShow==true"/>
        <AddUser v-if="modalAddUser==true" @messageToParent="handleshowModaleUser"/>
</template>