<script setup>
// Import from external libraries
import { computed } from 'vue';
import { useStore } from 'vuex';

// Import local components
  import AppLogin from '@/components/auth/AppLogin.vue';
  import AppSinUp from '@/components/auth/AppSinUp.vue';
  import AppHeader from '@/components/layouts/AppHeader.vue';

// Initialize the store
  const store = useStore();

// Computed property for the authentication form
  let form=computed(() => store.getters.getAuthForm);

const sinup=()=>{
    store.commit('setAuthForm','sinup');
  }
</script>
<template>
    <AppHeader />
    <!-- home start -->
     <div>
        <img class="h-full absolute -z-20" src="../assets/img/hero-image-2x.jpg" alt="">
        <div class="pt-24 px-8 md:px-32 flex flex-col items-start gap-5">
            <h1 class="text-center text-3xl max-md:text-2xl cursor-pointer font-bold text-blue-900">Discover a limitless world of learning</h1>
            <p class="w-80 mt-auto text-lg max-md:text-base mb-5 cursor-pointer">Cette plateforme éducative faciliter la gestion des devoirs et des heures supplémentaires pour les écoles</p>
            <button @click="sinup" class="mb-60 bg-blue-700 text-white py-3 px-8 max-md:py-2 max-md:px-6 rounded-xl hover:scale-105">join for free</button>
        </div>
     </div>
     <!-- section end -->
    <!--Start block login-->
    <div v-if="form=='login'">
        <AppLogin/>
    </div>
    <!-- End block -->
     <!--Start block sin up-->
    <div v-if="form=='sinup'">
        <AppSinUp/>
    </div>
    <!-- End block -->
</template>
<script>
</script>