<script setup>
import DashboardHeader from '@/components/dashboard/layouts/DashboardHeader.vue';
import DashboardNavBar from '@/components/dashboard/layouts/DashboardNavBar.vue';
import AppHome from '@/components/dashboard/Home/AppHome.vue';
import AppClass from '@/components/dashboard/Class/AppClass.vue';
import AppMeet from '@/components/dashboard/Meet/AppMeet.vue';
import AppNote from '@/components/dashboard/Note/AppNote.vue';
import AppParametre from '@/components/dashboard/Parametre/AppParametre.vue';
import AppProfile from '@/components/dashboard/Profile/AppProfile.vue';
import AppStatistique from '@/components/dashboard/Statistique/AppStatistique.vue';
import AppBoard from '@/components/dashboard/whiteboard/AppBoard.vue';
import { useStore } from 'vuex';
  import { computed } from 'vue';
const store = useStore();
const titleDashbord=computed(() => store.getters.getTitleDashbord);
</script>
<template>
  <div class="bg-slate-100 h-screen z-50">
      <!--heder start-->
     <DashboardHeader/>
       <!--heder end-->  
       <div class="w-full h-screen flex">
       <!--nav bar start--> 
     <DashboardNavBar/>
          <!--nav bar end-->
          <div class="mt-16 pt-2 ml-60">
            <div v-if="titleDashbord=='Home'"><AppHome/></div>
            <div v-if="titleDashbord=='Class'"><AppClass/></div>
            <div v-if="titleDashbord=='Meet'"><AppMeet/></div>
            <div v-if="titleDashbord=='Les Note'"><AppNote/></div>
            <div v-if="titleDashbord=='whiteboard'"><AppBoard/></div>
            <div v-if="titleDashbord=='Statistique'"><AppStatistique/></div>
            <div v-if="titleDashbord=='Profile'"><AppProfile/></div>
            <div v-if="titleDashbord=='Parametre'"><AppParametre/></div>
          </div>
          
     </div> 
     
  </div>
</template>
