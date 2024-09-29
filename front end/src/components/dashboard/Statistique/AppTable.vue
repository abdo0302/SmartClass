<script setup>
// Import from external libraries
import { onMounted,computed, ref ,watch } from 'vue';
import { useStore } from 'vuex';
// Import local components
import AlertMessage from '../Alerts/AlertMessage.vue';

  // Initialize the store 
const store = useStore();

const Users = computed(() => store.getters.getUsers);
const alertShow=ref(false);
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
</script>
<template>
    <div class="w-1/2 max-md:w-full bg-white p-3 shadow-md rounded-xl">
            <!-- table -->
            <div class="flex flex-col w-full mt-4 gap-1">
                <div class="flex bg-blue-100 py-1 px-3 justify-between items-center rounded-md">
                    <div class="w-2/5 text-sm font-semibold">Name</div>
                    <div class="w-2/3 text-sm text-center font-semibold">email</div>
                    <div class="w-2/5 text-sm font-semibold text-center max-md:hidden">Date de inscrire</div>
                    <div class="w-2/5 text-end text-sm font-semibold">Actes</div>
                </div>
                <div class="h-96 max-h-56 overflow-y-auto flex flex-col gap-2">
                    <div v-for="User in Users" :key="User.id" class="flex w-full bg-white px-2 items-center">
                       <div class="w-2/5 text-sm flex">{{ User.name }}</div>
                       <div class="w-2/3 text-nowrap text-sm ">{{ User.email }}</div>
                       <div class="w-2/5 text-sm text-center max-md:hidden">{{ formatDate(User.created_at) }}</div>
                       <div class="w-2/5 text-end flex justify-end gap-3"><button @click="deletUser(User.id)" class="bg-red-400 text-white px-3 rounded-md shadow-md hover:shadow-none"><i class="fa-solid fa-trash"></i></button></div>
                    </div>
                </div>
            </div>
        </div>
        <AlertMessage v-if="alertShow==true"/>
</template>