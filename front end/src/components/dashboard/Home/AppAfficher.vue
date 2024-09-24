<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
const store = useStore();
const Contenu=computed(()=>store.getters.getContenu);
const formatDate=(dateString)=> {
      // Créez un objet Date à partir de la chaîne de date
      const date = new Date(dateString);

      // Utilisez toLocaleDateString pour formater la date en AAAA-MM-JJ
      return date.toLocaleDateString('fr-CA'); // 'fr-CA' formate la date en 'yyyy-mm-dd'
    }
</script>
<template>
    <div class="flex justify-center">
          <div class="bg-white my-5 mx-10 py-3 px-9 rounded-xl flex flex-col w-1/2 shadow-md gap-6">
               <h3 class="text-center text-xl font-semibold">{{ Contenu.titre }}</h3>
               <p class="">{{ Contenu.description }}</p>
               <div class="flex justify-center"><button class="bg-blue-600 py-1 px-5 text-white rounded-md"> <a :href="'http://127.0.0.1:8000/'+Contenu.file">fichier</a></button></div>
               <span class="text-sm">créé : <span class="text-xs">{{ formatDate(Contenu.created_at) }}</span></span>   
          </div>
    </div>
    <IframeFile/>
</template>