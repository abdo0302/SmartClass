<script setup>
// Import from external libraries
import { computed } from 'vue';
  import { useStore } from 'vuex';
// Initialize the store
const store = useStore();
const closesideBar=computed(() => store.getters.getCloseSideBar);
const titleDashbord=(value)=>{
  store.commit('setTitleDashbord',value)
}
</script>
<template>
    <aside class="bg-white w-1/6 max-sm:h-fit max-sm:w-full max-xl:w-fit shadow-md h-screen fixed max-sm:bottom-0 mt-10 pt-12 max-sm:mt-0 max-sm:pt-0 transition-all duration-1000 ease-in-out" :id="closesideBar==true?'closeNav':''">
        <nav class="h-full max-sm:h-fit max-sm:w-full max-xl:w-fit transition-all duration-1000 ease-in-out" :id="closesideBar==true?'closeNav':''">
          <ul class="flex flex-col max-sm:flex-row max-sm:h-fit max-sm:w-full max-sm:justify-evenly max-sm:items-center h-full max-sm:py-3 max-xl:w-fit transition-all duration-1000 ease-in-out" :id="closesideBar==true?'closeNav':''">
            <li @click="titleDashbord('Home')" class="flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor"><i class="fa-solid fa-house text-2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Home</span></li>
            <li @click="titleDashbord('Class')" class="flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor"><i class="fa-solid fa-users-rectangle 2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Class</span></li>
            <li @click="titleDashbord('Meet')" class="flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor"><i class="fa-solid fa-video 2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Meet</span></li>
            <li @click="titleDashbord('Les Note')" class="flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor"><i class="fa-solid fa-file-pen 2xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Les Note</span></li>
            <li @click="titleDashbord('whiteboard')" class="flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor"><i class="fa-solid fa-pen-fancy 3xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">whiteboard</span></li>
            <li @click="titleDashbord('Statistique')" class="flex items-center px-7 gap-3 max-sm:gap-0 font-semibold text-lg hover:bg-gray-200 max-sm:hover:bg-white hover:pl-8 max-sm:hover:pl-0 max-sm:p-0 p-2 transition-all duration-1000 ease-in-out cursor"><i class="fa-solid fa-chart-line 3xl"></i><span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Statistique</span></li>
            <li class="max-sm:hidden flex items-center px-7 gap-3 font-semibold text-lg mt-auto hover:pl-8 mb-16 hover:bg-gray-200 max-sm:hover:bg-white p-2 transition-all duration-1000 ease-in-out cursor"><i class="fa-solid fa-arrow-right-from-bracket 3xl"></i> <span :class="['max-xl:hidden',closesideBar==true?'spanHidden':'']">Se déconnecter</span></li>
          </ul>
        </nav>
       </aside>
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
.cursor{
  cursor:url("../../../assets/img/pngwing.com\ \(10\).png"), auto;
}
</style>