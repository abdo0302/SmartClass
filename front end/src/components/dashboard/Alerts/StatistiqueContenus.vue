<script setup> 
import { computed } from 'vue';
import { useStore } from 'vuex';
const store = useStore();
const emit = defineEmits(['messageToParent']);
function sendMessage() {
  emit('messageToParent', false);
}
const Statistiques=computed(()=>store.getters.getStatistiqueContenu);
</script>
<template>
    <div class="w-full h-screen fixed top-0 left-0 z-50 bg-black/65 flex justify-center items-center">
        <div  class="relative w-1/4 bg-white shadow-xl rounded-xl py-3 px-4">
            <i @click="sendMessage" class="fa-solid fa-x absolute top-2 right-2 hover:bg-slate-200 w-7 h-7 rounded-full flex justify-center items-center"></i>
            <!-- header -->
            <div class="flex items-center justify-between ml-2">
                <div class="flex flex-col">
                    <span class="text-xl font-bold">Statistique</span>
                    <span class="text-xs text-slate-600">Vues {{ Statistiques.total }}</span>
                </div>
            </div>
            <!-- body -->
             <!-- table -->
            <div class="flex flex-col w-full mt-4 gap-1">
                <div class="flex bg-blue-100 py-1 px-3 items-center rounded-md">
                    <div class="w-2/5 text-sm font-semibold">Name</div>
                    <div class=" text-sm font-semibold text-center">email</div>
                </div>
                <div class="h-56 overflow-y-auto flex flex-col gap-2">
                    <div v-for="Statistique in Statistiques.statistique" :key="Statistique.id" class="flex w-full bg-white px-2 justify-between items-center">
                       <div class="w-2/5 text-sm">{{ Statistique.name }}</div>
                       <div class=" text-sm">{{ Statistique.email }}</div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</template>