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
import AppCalendrier from '@/components/dashboard/Calendrier/AppCalendrier.vue';
import AppContenus from '@/components/dashboard/Home/AppContenus.vue';
import AppExercices from '@/components/dashboard/Home/AppExercices.vue';
import AppAfficher from '@/components/dashboard/Home/AppAfficher.vue';
import AppHure from '@/components/dashboard/Hure/AppHure.vue';
// import AppNotif from '@/components/AppNotification.vue';
import { useStore } from 'vuex';
  import { computed } from 'vue';
const store = useStore();
const titleDashbord=computed(() => store.getters.getTitleDashbord);
const isCloseSideBar=computed(()=>store.getters.getCloseSideBar)
</script>
<template>
  <div class="bg-slate-100 z-50">
      <!--heder start-->
     <DashboardHeader/>
       <!--heder end-->  
       <div class="w-full h-screen flex">
       <!--nav bar start--> 
     <DashboardNavBar/>
          <!-- nav bar end -->
          <div :class="['mt-16 pt-2 w-full max-xl:ml-20 max-sm:ml-0',isCloseSideBar==true?'ml-24':'ml-56']">
            <div class="bg-slate-100" v-if="titleDashbord=='Home'"><AppHome/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Session'"><AppClass/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Meet'"><AppMeet/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Mes Notes'"><AppNote/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='whiteboard'"><AppBoard/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Statistique'"><AppStatistique/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Profile'"><AppProfile/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Parametre'"><AppParametre/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Calendrier'"><AppCalendrier/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Contenus'"><AppContenus/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Exercices'"><AppExercices/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Afficher'"><AppAfficher/></div>
            <div class="bg-slate-100" v-if="titleDashbord=='Hure'"><AppHure/></div>
          </div>
          <!-- <AppNotif/> -->
          
     </div> 
     
  </div>
</template>
