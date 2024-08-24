<script setup>
  import { useStore } from 'vuex';
  import { computed } from 'vue';
const store = useStore();
import { ref } from 'vue';

const menuHeight = ref('0px');
const menuPadding = ref('0px');
const menuBorder = ref('0px')

const toggleMenu = () => {
  menuHeight.value = menuHeight.value === '0px' ? '140px' : '0px';
  menuPadding.value = menuHeight.value === '0px' ? '0px' : '17px';
  menuBorder.value = menuHeight.value === '0px' ? '0px' : '1px'
};
const closesideBar=computed(() => store.getters.getCloseSideBar);
const titleDashbord=computed(() => store.getters.getTitleDashbord);
const CloseSideBar=()=>{
    store.commit('setCloseSideBar')
  }
const Dashbordtitle=(value)=>{
  store.commit('setTitleDashbord',value)
}
</script>
<template>
    <!--heder start-->
    <header class="bg-gradient-to-t from-white to-gray-50 shadow-sm w-full flex justify-between items-center px-5 py-3 fixed top-0 z-30">
          <!--container start-->
        <div class="flex items-center gap-6">
          <!--button nav bar-->
          <button @click="CloseSideBar" class="max-xl:hidden cursor">
            <i :class="closesideBar==true?'fa-solid fa-bars text-lg':'fa-solid fa-bars-staggered text-lg'"></i>
          </button>
            <!--logo start-->
            <img class="w-32 max-sm:w-28 cursor" src="../../../assets/img/logo.png" alt="">
          <!--logo end-->
          <span class="font-semibold text-xl ml-7 cursor">
            {{ titleDashbord }}
          </span>
        </div>
          <!--container end-->
          <!--container start-->
        <div class="flex items-center gap-6 max-md:gap-5">
          <!--button notisication-->
          <button class="flex relative">
            <div class="bg-red-600 text-white text-xs rounded-full w-4 h-4 flex justify-center items-center absolute -right-2 top-1">
              0
            </div>
            <i class="fa-solid fa-bell text-2xl max-sm:text-lg cursor"></i>
          </button>
          <!--profile-->
          <div @click="toggleMenu" class="flex justify-center items-center gap-2 mr-4 max-md:mr-0 relative">
            <span class="font-semibold max-md:hidden cursor">Abdelljabr</span>
            <!--logo profile-->
            <div class="bg-green-100 flex justify-center items-center h-10 max-sm:h-9 w-10 max-sm:w-9 max rounded-full shadow-sm border cursor">AB</div>
            <!--menu profile-->
            <div id="profileMenu" class="absolute flex flex-col gap-1 bg-white shadow-md top-12 right-1 h-0 overflow-hidden hover:h-auto px-5" :style="{ height: menuHeight, transition: 'all 1s ease', paddingTop:menuPadding ,borderWidth:menuBorder, borderColor: '#FFF5E4', borderStyle: 'solid'}">
              <span @click="Dashbordtitle('Profile')" class="px-2 py-1 bg-zinc-100 hover:bg-zinc-200 rounded-md cursor">Profile</span>
              <span class="px-2 py-1 text-nowrap bg-zinc-100 hover:bg-zinc-200 rounded-md hidden max-sm:flex cursor">Se deconnecter</span>
              <span @click="Dashbordtitle('Parametre')" class="px-2 py-1 bg-zinc-100 hover:bg-zinc-200 rounded-md cursor">Parametre</span>
            </div>
          </div>
        </div>
          <!--container end-->
      </header>
      <!--heder end-->
</template>
<style>
.cursor{
  cursor:url("../../assets/img/pngwing.com (10).png"), auto;
}
</style>