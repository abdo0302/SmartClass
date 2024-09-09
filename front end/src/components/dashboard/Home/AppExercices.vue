<script setup>
import { ref ,computed,watch } from 'vue';
import { useStore } from 'vuex';
  const isMenuVisible=ref({});
  const toggle=(id)=>{
     isMenuVisible.value[id]=!isMenuVisible.value[id];
}

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

  const IdClass=ref();
const Exercices=computed(()=>store.getters.getDevoirs);
watch(IdClass, (newClassId) => {
  if (newClassId) {
    if (Permissions_roles.value['roles']=='eleve') {
            console.log('v');
            
            
        }else{ 
          store.commit('setDevoirs', '');
          store.dispatch('getExercices', newClassId);
        }
  }
});

watch(lesClasses, (newClasses) => {
  if (newClasses.Classes && newClasses.Classes.length > 0) {
    IdClass.value = newClasses.Classes[0].id; 
    store.dispatch('getExercices', IdClass.value);
  }
});

const deleteExercice=(id)=>{
    store.dispatch('deleteExercice',id)
    store.dispatch('getExercices', IdClass);
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
            <div v-if="Exercices !=='Aucun'" class="w-full flex flex-wrap justify-evenly gap-3">
                    <div v-for="Exercice in Exercices" :key="Exercice.id" class="relative border-2 w-60 h-32 p-5 flex flex-col items-center gap-3 border-gray-300 rounded-lg shadow-md hover:shadow-none hover:border-gray-400">
                        <img class="w-12" src="../../../assets/img/contenu.png" alt="">
                        <i v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" @click="toggle(1)" class="button_more fa-solid fa-ellipsis-vertical absolute top-2 right-2 p-2"></i>
                        <p class="contenu text-center">{{ Exercice.titre }}</p>
                        <div v-if="isMenuVisible[1]" class="menu absolute top-8 right-5 bg-slate-50 border p-3 flex flex-col gap-1 shadow-md">
                            <span @click="deleteExercice(Exercice.id)" class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Supprimer</span>
                            <span class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Statistique</span>
                            <span class="bg-blue-100 hover:bg-blue-200 p-1 rounded-lg cursor-pointer">Correction</span>
                        </div>
                        <!-- menu end -->
                    </div>
                </div>
            <!-- contenar end -->
        </div>
        <div v-if="lesClasses =='Aucun' || Exercices =='Aucun'" class="flex justify-center">
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