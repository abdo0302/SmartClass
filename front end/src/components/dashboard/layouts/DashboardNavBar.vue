<script setup>
// Import from external libraries
import AddEvents from '../Alerts/AddEvents.vue';
import { computed,onMounted,ref } from 'vue';
  import { useStore } from 'vuex';
// Initialize the store
const store = useStore();
const closesideBar=computed(() => store.getters.getCloseSideBar);
const Permissions_roles=computed(() => store.getters.getPermissions_roles);
const Dashbordtitle=computed(() => store.getters.getTitleDashbord);
const titleDashbord=(value)=>{
  store.commit('setTitleDashbord',value)
  if (value=='whiteboard') {
     store.commit('setSideBarClose')
  }
}
const logOut=()=>{
    store.dispatch('logOut');
  }  
onMounted(()=>{
  store.dispatch('getPermissions_role');
});

const AlertAddEvent=ref(false)
const ShowAlertAddEvent=()=>{
  AlertAddEvent.value=true
}

function handleMessage(msg) {
  AlertAddEvent.value = msg;
}
</script>
<template>
    <aside class="z-40 px-1 bg-white w-1/6 max-sm:h-fit max-sm:w-full max-xl:w-fit shadow-lg shadow-slate-300 h-screen fixed max-sm:bottom-0 mt-14 pt-12 max-sm:mt-0 max-sm:pt-0 transition-all duration-1000 ease-in-out" :id="closesideBar==true?'closeNav':''">
        <nav class="h-full max-sm:h-fit max-sm:w-full max-xl:w-fit max-sm:border-t-2 transition-all duration-1000 ease-in-out" :id="closesideBar==true?'closeNav':''">
          <ul class="flex flex-col max-sm:flex-row max-sm:h-fit max-sm:w-full max-sm:justify-evenly max-sm:items-center h-full max-sm:py-3 max-xl:w-fit transition-all duration-1000 ease-in-out" :id="closesideBar==true?'closeNav':''">
            <li @click="titleDashbord('Home')" :class="['flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor-pointer',Dashbordtitle=='Home'?'bg-gray-200 hover:pl-8 max-sm:hover:pl-0':'']"><i class="fa-solid fa-house text-2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Home</span></li>
            <li v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" @click="titleDashbord('Session')" :class="['flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor-pointer',Dashbordtitle=='Session'?'bg-gray-200 hover:pl-8 max-sm:hover:pl-0':'']"><i class="fa-solid fa-users-rectangle text-2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Session</span></li>
            <li @click="titleDashbord('Meet')" :class="['flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor-pointer',Dashbordtitle=='Meet'?'bg-gray-200 hover:pl-8 max-sm:hover:pl-0':'']"><i class="fa-solid fa-video text-2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Meet</span></li>
            <li @click="titleDashbord('Mes Notes')" :class="['flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor-pointer',Dashbordtitle=='Mes Notes'?'bg-gray-200 hover:pl-8 max-sm:hover:pl-0':'']"><i class="fa-solid fa-file-pen text-2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Mes Notes</span></li>
            <li @click="titleDashbord('whiteboard')" :class="['flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor-pointer',Dashbordtitle=='whiteboard'?'bg-gray-200 hover:pl-8 max-sm:hover:pl-0':'']"><i class="fa-solid fa-pen-fancy text-2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">whiteboard</span></li>
            <li v-if="Permissions_roles.roles =='admin'" @click="titleDashbord('Statistique')" :class="['flex items-center px-7 gap-3 max-sm:gap-0 font-semibold hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor-pointer text-lg',Dashbordtitle=='Statistique'?'bg-gray-200 hover:pl-8 max-sm:hover:pl-0':'']"><i class="fa-solid fa-chart-line text-2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Statistique</span></li>
            <li  v-if="Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur'" :class="['flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor-pointer max-sm:hidden',Dashbordtitle=='Calendrier'?'bg-gray-200 hover:pl-8 max-sm:hover:pl-0':'']"><i @click="titleDashbord('Calendrier')" class="fa-solid fa-calendar-days text-2xl"></i><span @click="titleDashbord('Calendrier')" :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Calendrier </span><i v-if="(Permissions_roles.roles =='admin' || Permissions_roles.roles =='professeur')&& Dashbordtitle=='Calendrier'" @click="ShowAlertAddEvent" class="fa-solid fa-plus ml-4 font-extrabold text-xl fixed bottom-5 right-4 z-40 bg-white border-2 border-slate-500 w-9 h-9 rounded-full flex justify-center items-center shadow-xl hover:scale-105"></i></li>
            <li @click="titleDashbord('Hure')" :class="['flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor-pointer',Dashbordtitle=='Hure'?'bg-gray-200 hover:pl-8 max-sm:hover:pl-0':'']"><i class="fa-solid fa-clock  text-2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Hure</span></li>
            <li @click="logOut" class="text-nowrap max-sm:hidden flex items-center px-7 gap-3 font-semibold text-lg mt-auto hover:pl-8 mb-16 hover:bg-gray-200 max-sm:hover:bg-white p-2 transition-all duration-1000 ease-in-out cursor-pointer"><i class="fa-solid fa-arrow-right-from-bracket text-2xl"></i> <span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Se déconnecter</span></li>
          </ul>
        </nav> 
       </aside>
       <AddEvents v-if="AlertAddEvent==true" @messageToParent="handleMessage"/>
</template>
<style>
@media screen and (min-width: 640px){
  .spanHidden{
    display: none;
  }
  #closeNav{
    width: fit-content;
  }
}
</style>