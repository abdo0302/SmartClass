<script setup>
import AlertMessage from '../Alerts/AlertMessage.vue';
import AddExercices from '../Alerts/AddExercices.vue';
import AddContenu from '../Alerts/AddContenu.vue';
import StatistiqueContenus from '../Alerts/StatistiqueContenus.vue';
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

const AlertAddContenu=ref(false);
const AlertAddExercices=ref(false);
function handleMessage(msg) {
    AlertAddExercices.value = msg;
}
function handleMessage2(msg) {
    AlertAddContenu.value = msg;
}
const showAlert=()=>{
    AlertAddExercices.value=true;
}
const showAlertAddContenu=()=>{
    AlertAddContenu.value=true;
}

const getContenu=(id)=>{
    store.commit('setContenu','');
    store.dispatch('getContenu',id);
    titleDashbord('Afficher');
}
const getExercice=(id)=>{
    store.commit('setContenu','');
    store.dispatch('getExercice',id);
    titleDashbord('Afficher');
}
const ShowAlertStatistique=ref(false);
function handleMessage3(msg) {
    ShowAlertStatistique.value = msg;
}
const ShowStatistiqueContenu=(id)=>{
    ShowAlertStatistique.value=true;
    store.commit('SetStatistiqueContenu','');
    store.dispatch('getStatistique',id);
}
const ShowStatistiqueExercice=(id)=>{
    ShowAlertStatistique.value=true;
    store.commit('SetStatistiqueContenu','');
    store.dispatch('getStatistiqueExercice',id);
}
</script>
<template>
    <div v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" class="flex flex-col p-5 gap-5 bg-slate-100 mx-3">
        <!-- contenar start-->
        <div class="bg-white py-5 px-6 rounded-xl shadow-md flex flex-col gap-4">
            <div class="flex gap-9">
                <h3 class="text-2xl max-md:text-xl max-sm:text-lg font-semibold cursor-pointer">les exercices</h3>
                <button @click="showAlert" v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" class="bg-blue-600 hover:bg-blue-700 hover:ml-0.5 hover:scale-105 text-white py-1 px-3 rounded-lg">creer</button>
                <button @click="titleDashbord('Exercices')" class="ml-auto mr-4 text-lg text-blue-800 font-semibold hover:scale-105">All</button>
            </div>
            <!-- continar start -->
            <div v-if="DevoirsHome!=='Aucun'" class="w-full flex flex-wrap justify-evenly gap-3">
                <div v-for="DevoirHome in DevoirsHome" :key="DevoirHome.id" class="relative border-2 w-60 h-32 p-5 flex flex-col items-center gap-3 border-gray-300 rounded-lg shadow-md hover:shadow-none hover:border-gray-400 hover:scale-105">
                    <img @click="getExercice(DevoirHome.id)" class="w-12" src="../../../assets/img/exercice.png" alt="">
                    <i v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" @click="toggle(DevoirHome.id)" class="button_more fa-solid fa-ellipsis-vertical absolute top-2 right-2 p-2"></i>
                    <p @click="getExercice(DevoirHome.id)" class="contenu cursor-pointer">{{ DevoirHome.titre }}</p>
                     <div v-if="isMenuVisible[DevoirHome.id]" class="menu absolute top-8 right-5 bg-slate-50 border p-3 flex flex-col gap-1 shadow-md">
                        <span @click="deleteExercice(DevoirHome.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Supprimer</span>
                        <span @click="ShowStatistiqueExercice(DevoirHome.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Statistique</span>
                     </div>
                     <!-- menu end -->
                </div>
                <!-- loding start -->
                 <img v-if="DevoirsHome==''" class="animate-spin" src="../../../assets/img/pngwing.com (12).png" alt="">
                 <!-- loding end -->
            </div>
            <div v-if="DevoirsHome=='Aucun'" class="flex justify-center"><img class="w-72" src="../../../assets/img/animated_emty.gif" alt=""></div>
            <!-- continar end -->
        </div>
                <!-- contenar end-->
        <!-- contenar start-->
        <div class="bg-white py-5 px-6 mb-16 rounded-xl shadow-md flex flex-col gap-4">
            <div class="flex gap-9">
                <h3 class="text-2xl max-md:text-xl max-sm:text-lg font-semibold cursor-pointer">les contenus</h3>
                <button @click="showAlertAddContenu" v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" class="bg-blue-600 hover:bg-blue-700 hover:ml-0.5 hover:scale-105 text-white py-1 px-3 rounded-lg">creer</button>
                <button @click="titleDashbord('Contenus')" class="ml-auto mr-4 text-lg text-blue-800 font-semibold hover:scale-105">All</button>
            </div>
            <!-- Slider start -->
            <div v-if="ContenuHome!=='Aucun'" class="w-full flex flex-wrap justify-evenly gap-3">
                <div v-for="ContenuHom in ContenuHome" :key="ContenuHom.id" class="relative border-2 w-60 h-32 p-5 flex flex-col items-center gap-3 border-gray-300 rounded-lg shadow-md hover:shadow-none hover:border-gray-400 hover:scale-105">
                    <img  @click="getContenu(ContenuHom.id)" class="w-12" src="../../../assets/img/contenu.png" alt="">
                    <i @click="toggle(ContenuHom.id)" class="button_more fa-solid fa-ellipsis-vertical absolute top-2 right-2 p-2"></i>
                    <p  @click="getContenu(ContenuHom.id)" class="cursor-pointer contenu text-center">{{ ContenuHom.titre }}</p>
                     <div v-if="isMenuVisible[ContenuHom.id]" class="menu absolute cursor-pointer top-8 right-5 bg-slate-50 border p-3 flex flex-col gap-1 shadow-md">
                        <span @click="deletecontenu(ContenuHom.id)" class="bg-blue-100 cursor-pointer hover:bg-blue-200 p-1 rounded-lg">Supprimer</span>
                        <span @click="ShowStatistiqueContenu(ContenuHom.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg">Statistique</span>
                     </div>
                     <!-- menu end -->
                </div>
                <!-- loding start -->
                <img v-if="ContenuHome==''" class="animate-spin" src="../../../assets/img/pngwing.com (12).png" alt="">
                 <!-- loding end -->
            </div>
            <div v-if="ContenuHome=='Aucun'" class="flex justify-center"><img class="w-72" src="../../../assets/img/animated_emty.gif" alt=""></div>
            <!-- Slider end -->
        </div>
                <!-- contenar end-->
    </div>
    <div v-if="Permissions_roles.roles =='eleve'" class="flex justify-center items-center h-96 gap-7" >
        <!-- contenar start -->
        <div @click="titleDashbord('Exercices')" class="bg-stone-200 shadow-lg  rounded-lg w-1/4 max-md:w-1/3 border-2 border-slate-300 hover:border-slate-400 hover:scale-105">
            <img class="w-full h-36 rounded-t-md" src="../../../assets/img/image_devoir.jpg" alt="">
            <div class="px-3 flex flex-col gap-4">
                <span class="text-2xl max-md:text-xl font-semibold mb-2 ">les exercices</span>
            </div>
            
        </div>
        <!-- contenar end -->
         <!-- contenar start -->
        <div @click="titleDashbord('Contenus')" class="bg-stone-200 shadow-lg rounded-lg w-1/4 max-md:w-1/3 border-2 border-slate-300 hover:border-slate-400 hover:scale-105">
            <img class="w-full h-36 rounded-t-md" src="../../../assets/img/imag_contenus.jpg" alt="">
            <div class="px-3 flex flex-col gap-4">
                <span class="text-2xl max-md:text-xl font-semibold mb-2">les contenus</span>
            </div>
        </div>
    </div>
    <!-- login -->
     <div v-if="Permissions_roles ==''" class="flex justify-center items-center h-36"><img class="w-28" src="../../../assets/img/load-32_256.gif" alt=""></div>
    <!-- contenar end -->
    <AlertMessage v-if="AlertVisible==true" />
    <!-- alert add exercice -->
     <AddExercices v-if="AlertAddExercices ==true" @messageToParent="handleMessage"/>
     <AddContenu v-if="AlertAddContenu==true" @messageToParent="handleMessage2"/>
    <StatistiqueContenus v-if="ShowAlertStatistique==true" @messageToParent="handleMessage3"/>
</template>
<style scoped>
  .contenu {
    width: 24ch;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
  
</style>