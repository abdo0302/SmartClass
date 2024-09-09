<script setup>
import AlertMessage from '../Alerts/AlertMessage.vue';
import { onMounted,computed, ref,watch } from 'vue';
import { useStore } from 'vuex';
const store = useStore();
const DevoirsHome =computed(()=>store.getters.getDevoirHome);
const ContenuHome =computed(()=>store.getters.getContenuHome);
const Permissions_roles=computed(() => store.getters.getPermissions_roles);
onMounted(()=>{
    store.dispatch('getPermissions_role');
    
});

watch(Permissions_roles, (newPermissions_roles) => {
  if (newPermissions_roles !== '') {
        if (Permissions_roles.value['roles']=='eleve') {
            console.log('h');
            
        }else{ 
        store.dispatch('getdevoir');
        store.dispatch('getcontenu');
        }
  }
}); 

const isMenuVisible=ref({});
const toggle=(id)=>{
    isMenuVisible.value[id]=!isMenuVisible.value[id];
}

const titleDashbord=(value)=>{
    store.commit('setTitleDashbord',value)
    }

const deleteExercice=(id)=>{
    store.dispatch('deleteExercice',id);
    AlertVisible.value=true;
    store.dispatch('getdevoir');
}   

const AlertVisible=ref(false);
const deletecontenu=(id)=>{
    store.dispatch('deletecontenu',id)
    AlertVisible.value=true;
    store.dispatch('getcontenu');
}
const Message=computed(()=>store.getters.getMessage);
watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
        AlertVisible.value=false;
    },1500);
  }
});  

</script>
<template>
    <div v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" class="flex flex-col p-5 gap-5 bg-slate-100 mx-3">
        <!-- contenar start-->
        <div class="bg-white py-5 px-6 rounded-xl shadow-md flex flex-col gap-4">
            <div class="flex gap-9">
                <h3 class="text-2xl font-semibold">les exercices</h3>
                <button v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" class="bg-blue-600 hover:bg-blue-700 hover:ml-0.5 hover:scale-105 text-white py-1 px-3 rounded-lg">creer</button>
                <button @click="titleDashbord('Exercices')" class="ml-auto mr-4 text-lg text-blue-800 font-semibold hover:scale-105">All</button>
            </div>
            <!-- Slider start -->
            <div class="w-full flex flex-wrap justify-evenly gap-3">
                <div v-for="DevoirHome in DevoirsHome" :key="DevoirHome.id" class="relative border-2 w-60 h-32 p-5 flex flex-col items-center gap-3 border-gray-300 rounded-lg shadow-md hover:shadow-none hover:border-gray-400">
                    <img class="w-12" src="../../../assets/img/exercice.png" alt="">
                    <i v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" @click="toggle(DevoirHome.id)" class="button_more fa-solid fa-ellipsis-vertical absolute top-2 right-2 p-2"></i>
                    <p class="contenu">{{ DevoirHome.titre }}</p>
                     <div v-if="isMenuVisible[DevoirHome.id]" class="menu absolute top-8 right-5 bg-slate-50 border p-3 flex flex-col gap-1 shadow-md">
                        <span @click="deleteExercice(DevoirHome.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Supprimer</span>
                        <span class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Statistique</span>
                        <span class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Correction</span>
                     </div>
                     <!-- menu end -->
                </div>
            </div>
            <!-- Slider end -->
        </div>
                <!-- contenar end-->
        <!-- contenar start-->
        <div class="bg-white py-5 px-6 rounded-xl shadow-md flex flex-col gap-4">
            <div class="flex gap-9">
                <h3 class="text-2xl font-semibold">les contenus</h3>
                <button v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" class="bg-blue-600 hover:bg-blue-700 hover:ml-0.5 hover:scale-105 text-white py-1 px-3 rounded-lg">creer</button>
                <button @click="titleDashbord('Contenus')" class="ml-auto mr-4 text-lg text-blue-800 font-semibold hover:scale-105">All</button>
            </div>
            <!-- Slider start -->
            <div class="w-full flex flex-wrap justify-evenly gap-3">
                <div v-for="ContenuHom in ContenuHome" :key="ContenuHom.id" class="relative border-2 w-60 h-32 p-5 flex flex-col items-center gap-3 border-gray-300 rounded-lg shadow-md hover:shadow-none hover:border-gray-400">
                    <img class="w-12" src="../../../assets/img/contenu.png" alt="">
                    <i @click="toggle(ContenuHom.id)" class="button_more fa-solid fa-ellipsis-vertical absolute top-2 right-2 p-2"></i>
                    <p class="contenu text-center">{{ ContenuHom.titre }}</p>
                     <div v-if="isMenuVisible[ContenuHom.id]" class="menu absolute top-8 right-5 bg-slate-50 border p-3 flex flex-col gap-1 shadow-md">
                        <span @click="deletecontenu(ContenuHom.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg">Supprimer</span>
                        <span class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg">Statistique</span>
                        <span class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg">Correction</span>
                     </div>
                     <!-- menu end -->
                </div>
            </div>
            <!-- Slider end -->
        </div>
                <!-- contenar end-->
    </div>
    <div v-if="Permissions_roles.roles =='eleve'" class="flex flex-wrap justify-center items-center h-96 gap-7" >
        <!-- contenar start -->
        <div @click="titleDashbord('Exercices')" class="bg-stone-200 shadow-lg  rounded-lg w-1/3 h-72 border-2 border-slate-300 hover:border-slate-400 hover:scale-105">
            <img class="w-full h-1/2 rounded-t-md" src="../../../assets/img/image_devoir.jpg" alt="">
            <div class="px-3 flex flex-col gap-4">
                <span class="text-2xl font-semibold">les exercices</span>
                <div class="relative h-2 w-4/5 ml-4 mr-auto shadow-sm shadow-slate-400 bg-blue-200 border-2 border-slate-400 rounded-full flex items-center">
                    <span class="absolute bottom-1 right-0 text-sm">50%</span>
                    <div class="bg-blue-400 h-1 w-1/2"></div>
                </div>
                <div class="flex justify-between px-3">
                    <span>les class <span>10</span></span>
                    <span>les exercices <span>20</span></span>
                </div>
            </div>
            
        </div>
        <!-- contenar end -->
         <!-- contenar start -->
        <div @click="titleDashbord('Contenus')" class="bg-stone-200 shadow-lg rounded-lg w-1/3 h-72 border-2 border-slate-300 hover:border-slate-400 hover:scale-105">
            <img class="w-full h-1/2 rounded-t-md" src="../../../assets/img/imag_contenus.jpg" alt="">
            <div class="px-3 flex flex-col gap-4">
                <span class="text-2xl font-semibold">les contenus</span>
                <div class="relative h-2 w-4/5 ml-4 mr-auto shadow-sm shadow-slate-400 bg-blue-200 border-2 border-slate-400 rounded-full flex items-center">
                    <span class="absolute bottom-1 right-0 text-sm">50%</span>
                    <div class="bg-blue-400 h-1 w-1/3"></div>
                </div>
                <div class="flex justify-between px-3">
                    <span>les class <span>10</span></span>
                    <span>les contenus <span>20</span></span>
                </div>
            </div>
        </div>
    </div>
    <!-- contenar end -->
    <AlertMessage v-if="AlertVisible==true" />
</template>
<style scoped>
  .contenu {
    width: 24ch;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
  
</style>