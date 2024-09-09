<script setup>
import InterfaceMeet from './interfaceMeet.vue';
import { computed, ref} from 'vue';
  import { useStore } from 'vuex';
// Initialize the store
const store = useStore();
const Permissions_roles=computed(() => store.getters.getPermissions_roles);
const lesClasses=computed(()=>store.getters.getClasses);

  if (Permissions_roles.value !== '') {
        if (Permissions_roles.value['roles']=='eleve') {
            store.dispatch('getClassesEleve'); 
            console.log('v');
            
            
        }else{ 
         store.dispatch('getClasses');
         console.log('vg');
        }
  }


let interface_visable=ref(false);
const getRoome=(id)=>{
  store.dispatch('getRoome',id);
  interface_visable.value=true;
}

function handleMessage(msg) {
  interface_visable.value=msg;
}
</script>
<template>
    <div class="mx-12 my-3 bg-white px-4 py-2 flex flex-col gap-4 shadow-md border-2 rounded-xl">
        <h3 class="text-center text-lg font-semibold cursor-pointer">Sélectionner une Roome</h3>
        <div class="flex justify-center flex-wrap gap-4 h-96 my-5 overflow-y-auto">
            <div v-for="Classes in lesClasses.Classes" :key="Classes.id" @click="getRoome(Classes.id)" class="w-1/6 h-44 border-2 shadow-md rounded-lg p-4 flex flex-col items-center justify-center">
              <img class="w-4/5" src="../../../assets/img/icone_meet.png" alt="">
              <span @click="getRoome(Classes.id)" class="title text-center cursor-pointer">{{ Classes.name }}</span>
            </div>
        </div>
    </div>
    <!-- interface Meet -->
    <InterfaceMeet v-if="interface_visable==true" @messageToParent="handleMessage"/>
</template>
<style scoped>
  .title {
    width: 15ch;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>