<script setup>
// Import from external libraries
  import { computed } from 'vue';
  import { useStore } from 'vuex';

// Import local components
  import { LiveChatWidget } from '@livechat/widget-vue'
  import AppLogin from '@/components/auth/AppLogin.vue';
  import AppSinUp from '@/components/auth/AppSinUp.vue';
  import AppHeader from '@/components/layouts/AppHeader.vue';

// Initialize the store
  const store = useStore();

// Computed property for the authentication form
  let form=computed(() => store.getters.getAuthForm);
</script>
<template>
    <AppHeader />
    <!-- home start -->
     <div>
        <img class="h-screen absolute -z-20" src="../assets/img/hero-image-2x.jpg" alt="">
        <div class="h-screen pt-24 px-32 flex flex-col items-start">
            <h1 class="text-center w-full text-3xl font-bold text-blue-900">Discover a limitless world of learning</h1>
            <p class="w-80 mt-auto text-lg mb-5">Cette plateforme éducative faciliter la gestion des devoirs et des heures supplémentaires pour les écoles</p>
            <button class="mb-60 bg-blue-700 text-white py-3 px-8 rounded-xl">join for free</button>
        </div>
     </div>
     <!-- home end -->
      <!-- section start -->
     <div class="bg-gradient-to-l from-blue-500 to-blue-800 flex flex-col justify-evenly h-screen">
       <h1 class="text-center text-4xl font-bold text-white">Join the Education.com community!</h1>
       <div class="flex justify-evenly">
           <!-- card start-->
          <div class="w-44 flex flex-col gap-4">
            <img src="../assets/img/Floyd.png" alt="">
            <span class="text-lg font-semibold text-white"><span class="text-yellow-300 font-semibold">44 million </span> parents, teachers, and students served</span>
          </div>
          <!-- card end-->
          <!-- card start-->
          <div class="w-44 flex flex-col gap-4">
            <img src="../assets/img/IceCream (1).png" alt="">
            <span class="text-lg font-semibold text-white">Used in <span class="text-yellow-300 font-semibold">20 countries</span> across 6 continents</span>
          </div>
          <!-- card end-->
          <!-- card start-->
          <div class="w-44 flex flex-col gap-4">
            <img src="../assets/img/TuTu.png" alt="">
            <span class="text-lg font-semibold text-white">Library with <span class="text-yellow-300 font-semibold">37,000</span> educational resources</span>
          </div>
          <!-- card end-->
       </div>
     </div>
     <!-- section end -->
      <!-- section start -->
       <div>
         <img class="absolute -z-20" src="../assets/img/Roly-Rocket-1600.png" alt="">
         <div class="h-full flex flex-col items-center pt-20 w-1/2">
           <h1 class="text-5xl font-semibold text-white mb-6">Get access today!</h1>
           <button class="mb-48 bg-blue-700 text-white py-3 px-9 rounded-xl font-semibold">join for free</button>
         </div>
       </div>
       <!-- section end -->
        <!-- footer start -->
         <footer class="bg-slate-900 h-64 flex flex-col justify-evenly">
             <!-- contenar start -->
            <div class="flex justify-center gap-4">
              <button><i class="fa-brands fa-facebook bg-white w-12 h-12 text-2xl rounded-full flex justify-center items-center"></i></button>
              <button><i class="fa-brands fa-square-instagram bg-white w-12 h-12 text-2xl rounded-full flex justify-center items-center"></i></button>
              <button><i class="fa-brands fa-linkedin bg-white w-12 h-12 text-2xl rounded-full flex justify-center items-center"></i></button>
            </div>
            <!-- contenar end -->
             <!-- contenar start -->
            <div class="flex justify-center">
               <span class="text-white">Copyright © 2024 Education.com, Inc, a division of IXL Learning • All Rights Reserved.</span>
            </div>
            <!-- contenar end -->
         </footer>
         <!-- footer start -->
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
  <LiveChatWidget license="18423141" />
</template>
<script>
</script>