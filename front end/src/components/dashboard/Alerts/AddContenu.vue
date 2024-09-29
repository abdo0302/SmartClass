<script setup>
// Import from external libraries
import { ref, watch, computed, reactive } from 'vue';
import { useStore } from 'vuex';
import AlertMessage from './AlertMessage.vue';

// Initialize the store 
const store = useStore();
const emit = defineEmits(['messageToParent']);

const Permissions_roles = computed(() => store.getters.getPermissions_roles);
const lesClasses = computed(() => store.getters.getClasses);
const CardShow = ref(false);
const infoContenu = reactive({titre: '', description: '', file: null, in_classe: ''});
const Message = computed(() => store.getters.getMessage);


// Watch for changes in permissions and dispatch the appropriate action
watch(Permissions_roles, (newRoles) => {
  if (newRoles && newRoles !== '') {
    if (newRoles.roles === 'eleve') {
      store.dispatch('getClassesEleve');
    } else {
      store.dispatch('getClasses');
    }
  }
}, { immediate: true });

const handleFileChange = (event) => {
  infoContenu.file = event.target.files[0];
};

// Function Add Contenu
const AddContenu = async () => {
  const formData = new FormData();
  formData.append('titre', infoContenu.titre);
  formData.append('description', infoContenu.description);
  formData.append('file', infoContenu.file);
  formData.append('in_classe', infoContenu.in_classe);

  store.dispatch('addContenu', formData);
  CardShow.value = true
};



 // Watch the message state to Close Alert Message
watch(Message, (newMessage) => {
  if (newMessage !== '') {
    setTimeout(() => {
      store.dispatch('getcontenu');
      store.commit('setMessage','');
      CardShow.value = false;
      sendMessage()
    }, 1500);
  }
});

function sendMessage() {
  emit('messageToParent', false);
}
</script>

<template>
  <div class="bg-black/70 fixed top-0 right-0 w-full h-screen z-50 flex justify-center items-center">
    <div class="bg-white p-5 rounded-xl flex flex-col w-1/3 items-center relative">
      <i @click="sendMessage" class="fa-solid fa-x absolute top-2 left-2 hover:bg-slate-300 p-2 rounded-full"></i>
      <span class="text-xl font-semibold">Ajouter une Contenu</span>
      <div class="w-full flex flex-col justify-center items-center gap-4 mt-6">
        <input v-model="infoContenu.titre" type="text" class="w-4/5 block border-2 border-slate-300 rounded-md py-1 px-2 shadow-sm shadow-slate-400 bg-slate-100" placeholder="Titre de Contenu">
        <textarea v-model="infoContenu.description" class="border-2 w-4/5 max-h-14" name="" id="" placeholder="Description"></textarea>
        <input @change="handleFileChange" type="file" id="myFile" name="filename">
        <select v-model="infoContenu.in_classe" class="bg-slate-100 border-2 border-slate-300 px-3">
          <option value="" selected disabled hidden>Choisissez la Class</option>
          <option v-for="lesClasse in lesClasses.Classes" :key="lesClasse.id" :value="lesClasse.id">{{ lesClasse.name }}</option>
        </select>
        <button @click="AddContenu" class="bg-blue-500 text-white p-2 px-4 rounded-lg">Créer</button>
      </div>
    </div>
  </div>
  <!-- Alert Message -->
  <AlertMessage v-if="CardShow" :message="Message" />
</template>