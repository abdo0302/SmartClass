<script setup>
// Import from external libraries
import { ref ,computed ,watch} from 'vue';
import { useStore } from 'vuex';
// Import local components
import AlertMessage from '../Alerts/AlertMessage.vue';
import AddContenu from '../Alerts/AddContenu.vue';
import StatistiqueContenus from '../Alerts/StatistiqueContenus.vue';

// Initialize the store
const store = useStore();

  const isMenuVisible=ref({});
  const Permissions_roles=computed(() => store.getters.getPermissions_roles);
  const lesClasses=computed(()=>store.getters.getClasses);
  const IdClass=ref();
  const Contenus=computed(()=>store.getters.getContenus);
  const AlertVisible=ref(false);
  const Message=computed(()=>store.getters.getMessage);
  const AlertAddContenu=ref(false);
  const ShowAlertStatistique=ref(false);


  // Function Show or close menu card
  const toggle=(id)=>{
     isMenuVisible.value[id]=!isMenuVisible.value[id];
 }


  if (Permissions_roles.value !== '') {
        if (Permissions_roles.value['roles']=='eleve') {
            store.dispatch('getClassesEleve');           
        }else{ 
         store.dispatch('getClasses');
        }
  }

watch(IdClass, (newClassId) => {
  if (newClassId) {
    if (Permissions_roles.value['roles']=='eleve') {
      store.commit('setContenus', '');
      store.dispatch('getContenusEleve', newClassId);
                     
        }else{ 
          store.commit('setContenus', '');
          store.dispatch('getContenus', newClassId);
        }
  }
});

watch(lesClasses, (newClasses) => {
  if (newClasses.Classes && newClasses.Classes.length > 0) {
    IdClass.value = newClasses.Classes[0].id; 
    if (Permissions_roles.value['roles']=='eleve') {
      store.dispatch('getContenusEleve', IdClass.value);          
        }else{ 
          store.dispatch('getContenus', IdClass.value);
        }
  }
});

// Function Delete Contenu
const deletecontenu=(id)=>{
    store.dispatch('deletecontenu',id)
    AlertVisible.value=true;
    store.dispatch('getContenus',IdClass.value);
}

  // Watch the message state to Close Alert Message
watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
        AlertVisible.value=false;
    },1500);
  }
});  


function handleMessage(msg) {
    AlertAddContenu.value = msg;
}

// Function show Alert AddContenu
const showAlertAddContenu=()=>{
    AlertAddContenu.value=true;
}

// Function Update Title Dashbord
const titleDashbord=(value)=>{
    store.commit('setTitleDashbord',value)
    }

// Function Show page Afficher Contenu
const getContenu=(id)=>{
    store.commit('setContenu','');
    if (Permissions_roles.value['roles']=='eleve') {
          store.dispatch('getContenuEleve',id);        
        }else{ 
          store.dispatch('getContenu',id);
        }
    titleDashbord('Afficher');
}

// Function Close Alert Statistique
function handleMessage2(msg) {
    ShowAlertStatistique.value = msg;
}

// Function Show Alert Statistique
const ShowStatistique=(id)=>{
    ShowAlertStatistique.value=true;
    store.commit('SetStatistiqueContenu','');
    store.dispatch('getStatistique',id);
}
</script>
<template>
    <div class="bg-white py-4 px-6 rounded-lg mx-10 my-4 shadow-md">
        <div v-if="lesClasses !=='Aucun'" >
                <!-- contenar start -->
            <div class="flex justify-between">  
                <button @click="showAlertAddContenu" class="bg-blue-400 text-white px-4 py-1 rounded-md shadow-md hover:shadow-none">créer</button>
                <select v-if="lesClasses !==''" v-model="IdClass" class="border-2 border-slate-400 rounded-lg px-5 bg-slate-100 shadow-md" name="" id="">
                    <option v-for="lesClasse in lesClasses.Classes" :key="lesClasse.id" :value="lesClasse.id">{{ lesClasse.name }}</option>
                </select>
            </div>
            <!-- contenar end -->
            <!-- contenar start -->
            <div v-if="Contenus !=='Aucun'" class="w-full flex flex-wrap justify-evenly gap-3 mt-6">
                    <div v-for="Contenu in Contenus" :key="Contenu.id" class="relative border-2 w-60 h-32 p-5 flex flex-col items-center gap-3 border-gray-300 rounded-lg shadow-md hover:shadow-none hover:border-gray-400 hover:scale-105">
                        <img @click="getContenu(Contenu.id)" class="w-12" src="../../../assets/img/contenu.png" alt="">
                        <i v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" @click="toggle(Contenu.id)" class="button_more fa-solid fa-ellipsis-vertical absolute top-2 right-2 p-2"></i>
                        <p @click="getContenu(Contenu.id)" class="contenu text-center cursor-pointer">{{ Contenu.titre }}</p>
                        <div v-if="isMenuVisible[Contenu.id]" class="menu absolute top-8 right-5 bg-slate-50 border p-3 flex flex-col gap-1 shadow-md">
                            <span @click="deletecontenu(Contenu.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Supprimer</span>
                            <span @click="ShowStatistique(Contenu.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Statistique</span>
                        </div>
                        <!-- menu end -->
                    </div>
                     <!-- loding start -->
                     <img v-if="Contenus==''" class="animate-spin" src="../../../assets/img/pngwing.com (12).png" alt="">
                     <!-- loding end -->
            </div>
            <!-- contenar end -->
        </div>
        <div v-if="lesClasses =='Aucun' || Contenus =='Aucun'" class="flex justify-center">
            <img class="w-1/2" src="../../../assets/img/animated_emty.gif" alt="">
        </div>
    </div>
    <AlertMessage v-if="AlertVisible==true"/>
    <AddContenu v-if="AlertAddContenu==true" @messageToParent="handleMessage"/>
    <StatistiqueContenus v-if="ShowAlertStatistique==true" @messageToParent="handleMessage2"/>
</template>
<style scoped>
  .contenu {
    width: 24ch;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
  
</style>