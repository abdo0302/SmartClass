<script setup>
import { ref ,computed ,watch ,onMounted} from 'vue';
import { useStore } from 'vuex';
  const isMenuVisible=ref({});
  const toggle=(id)=>{
     isMenuVisible.value[id]=!isMenuVisible.value[id];
}

  
// Initialize the store
const store = useStore();
const Permissions_roles=computed(() => store.getters.getPermissions_roles);
const lesClasses=computed(()=>store.getters.getClasses);

onMounted(()=>{
  store.commit('setPermissions_roles','')
  store.dispatch('getPermissions_role');
});

  if (Permissions_roles.value !== '') {
        if (Permissions_roles.value['roles']=='eleve') {
            store.dispatch('getClassesEleve');           
        }else{ 
          console.log('v');
          
         store.dispatch('getClasses');
        }
  }
const IdClass=ref();
const Contenus=computed(()=>store.getters.getContenus);
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
    console.log('fcccc');
    
    IdClass.value = newClasses.Classes[0].id; 
    store.dispatch('getContenus', IdClass.value);
  }
});

const deletecontenu=(id)=>{
    store.dispatch('deletecontenu',id)
    store.dispatch('getContenus',IdClass.value);
}
</script>
<template>
    <div class="bg-white py-3 px-6 rounded-lg mx-10 my-4 shadow-md">
        <div v-if="lesClasses !=='Aucun'" >
                <!-- contenar start -->
            <div class="flex justify-between">  
                <button class="bg-blue-400 text-white px-4 py-1 rounded-md">creer</button>
                <select v-model="IdClass" class="border-2 border-slate-400 rounded-lg px-5 bg-slate-100" name="" id="">
                    <option v-for="lesClasse in lesClasses.Classes" :key="lesClasse.id" :value="lesClasse.id">{{ lesClasse.name }}</option>
                </select>
            </div>
            <!-- contenar end -->
            <!-- contenar start -->
            <div v-if="Contenus !=='Aucun'" class="w-full flex flex-wrap justify-evenly gap-3">
                    <div v-for="Contenu in Contenus" :key="Contenu.id" class="relative border-2 w-60 h-32 p-5 flex flex-col items-center gap-3 border-gray-300 rounded-lg shadow-md hover:shadow-none hover:border-gray-400">
                        <img class="w-12" src="../../../assets/img/contenu.png" alt="">
                        <i v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" @click="toggle(1)" class="button_more fa-solid fa-ellipsis-vertical absolute top-2 right-2 p-2"></i>
                        <p class="contenu text-center">{{ Contenu.titre }}</p>
                        <div v-if="isMenuVisible[1]" class="menu absolute top-8 right-5 bg-slate-50 border p-3 flex flex-col gap-1 shadow-md">
                            <span @click="deletecontenu(Contenu.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg">Supprimer</span>
                            <span class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg">Statistique</span>
                            <span class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg">Correction</span>
                        </div>
                        <!-- menu end -->
                    </div>
            </div>
            <!-- contenar end -->
        </div>
        <div v-if="lesClasses =='Aucun' || Contenus =='Aucun'" class="flex justify-center">
            <img class="w-1/2" src="../../../assets/img/animated_emty.gif" alt="">
        </div>
    </div>
</template>
<style scoped>
  .contenu {
    width: 24ch;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
  
</style>