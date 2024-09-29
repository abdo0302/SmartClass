<script setup>
// Import from external libraries
import { computed, ref} from 'vue';
import { useStore } from 'vuex';
// Import local components
import InterfaceMeet from './interfaceMeet.vue';
import SessionCalendrier from './SessionCalendrier.vue';

// Initialize the store
const store = useStore();

const Permissions_roles=computed(() => store.getters.getPermissions_roles);
const lesClasses=computed(()=>store.getters.getClasses);
let interface_visable=ref(false);
const ShowCalendr=ref(false);

  if (Permissions_roles.value !== '') {
        if (Permissions_roles.value['roles']=='eleve') {
            store.dispatch('getClassesEleve'); 
        }else{ 
         store.dispatch('getClasses');
        }
  }

const getRoome=(id)=>{
  store.dispatch('getRoome',id);
  interface_visable.value=true;
}

function handleMessage(msg) {
  interface_visable.value=msg;
}

const setCalendarClass=(id)=>{
    store.commit('setevents','');
    store.dispatch('getEvents',id);
    ShowCalendr.value=true;
}

function handleMessage2(msg) {
  ShowCalendr.value=msg;
}
</script>
<template>
    <div class="mx-12 my-3 bg-white px-4 py-2 flex flex-col gap-4 shadow-md border-2 rounded-xl">
        <h3 v-if="lesClasses !=='Aucun'" class="text-center text-lg font-semibold cursor-pointer">Sélectionner une Roome</h3>
          <!-- loding start -->
        <div v-if="lesClasses==''" class="flex justify-center mt-7"><img  class="animate-spin" src="../../../assets/img/pngwing.com (12).png" alt=""></div>
          <!-- loding end -->
        <div v-else-if="lesClasses=='Aucun'" class="flex justify-center"><img  class="w-64" src="../../../assets/img/animated_emty.gif" alt=""></div>
        <div v-else class="flex justify-center flex-wrap gap-4 h-96 my-5 overflow-y-auto">
            <div v-for="Classes in lesClasses.Classes" :key="Classes.id" class="relative w-44 h-44 border-2 shadow-md rounded-lg p-4 flex flex-col items-center justify-center">
              <i @click="setCalendarClass(Classes.id)" class="fa-solid fa-calendar-days absolute top-2 left-4 text-xl"></i>
              <img @click="getRoome(Classes.id)" class="w-4/5" src="../../../assets/img/icone_meet.png" alt="">
              <span @click="getRoome(Classes.id)" class="title text-center cursor-pointer">{{ Classes.name }}</span>
            </div>
        </div>
    </div>
    <!-- interface Meet -->
    <InterfaceMeet v-if="interface_visable==true" @messageToParent="handleMessage"/>
    <SessionCalendrier v-if="ShowCalendr==true" @messageToParent="handleMessage2" />
</template>
<style scoped>
  .title {
    width: 15ch;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>