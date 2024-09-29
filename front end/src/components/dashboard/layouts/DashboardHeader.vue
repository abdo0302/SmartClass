<script setup>
// Import from external libraries
import { useStore } from 'vuex';
import { computed, onMounted, watch } from 'vue';
import { ref } from 'vue';
// Import local components
import AppNotification from '../Notification/AppNotification.vue';
   
// Initialize the store 
const store = useStore();

const menuHeight = ref('0px');
const menuPadding = ref('0px');
const menuBorder = ref('0px')

const toggleMenu = () => {
  menuHeight.value = menuHeight.value === '0px' ? '140px' : '0px';
  menuPadding.value = menuHeight.value === '0px' ? '0px' : '17px';
  menuBorder.value = menuHeight.value === '0px' ? '0px' : '1px'
};

 const MenuNotifiHeight = ref('0px');
const MenuNotifiPadding = ref('0px');
const MenuNotifiBorder = ref('0px')
 const toggleMenuNotifi=()=>{
  MenuNotifiHeight.value = MenuNotifiHeight.value === '0px' ? '' : '0px';
  MenuNotifiPadding.value = MenuNotifiHeight.value === '0px' ? '0px' : '';
  MenuNotifiBorder.value = MenuNotifiHeight.value === '0px' ? '0px' : ''
    
 }
const closesideBar=computed(() => store.getters.getCloseSideBar);
const titleDashbord=computed(() => store.getters.getTitleDashbord);
const User_info=computed(()=>store.getters.getUser);

const CloseSideBar=()=>{
    store.commit('setCloseSideBar')
  }
const Dashbordtitle=(value)=>{
  store.commit('setTitleDashbord',value)
}
onMounted(() => {
  store.dispatch('me')
  store.dispatch('getPermissions_role');
})
let user_name=ref('');
let logo=ref('');
watch(User_info, (User_info) => {
  if (User_info !=='') {
      user_name.value=User_info.name;
      for(let i=0;i<2;i++){
       logo.value+=user_name.value[i].toUpperCase()
     }
  }
  })
 const logOut=()=>{
    store.dispatch('logOut');
  }  
  // to home

  const Dashbord=(value)=>{
    store.commit('setTitleDashbord',value)
  }
  const newMessages = computed(() => store.getters.getNotificationMessage);
const TotaleNotification = ref(0);

// Watcher sur newMessages
watch(newMessages, (newMessage) => {
  // Vérifiez si newMessage.value est défini et est un tableau
  if (Array.isArray(newMessage)) {
    TotaleNotification.value = newMessage.length;
  } else {
    TotaleNotification.value = 0; // Si newMessage n'est pas un tableau, on met 0
  }
});
  
function handleMessage(msg) {
  TotaleNotification.value += msg;
}
const Permissions_roles=computed(() => store.getters.getPermissions_roles);
</script>
<template>
    <!--heder start-->
    <header class="bg-gradient-to-t from-white to-gray-50 shadow-sm shadow-slate-300 w-full flex justify-between items-center px-5 py-3 fixed top-0 z-30">
          <!--container start-->
        <div class="flex items-center gap-6 relative z-50">
          <!--button nav bar-->
          <button @click="CloseSideBar" class="max-xl:hidden cursor-pointer">
            <i :class="closesideBar==true?'fa-solid fa-bars text-lg':'fa-solid fa-bars-staggered text-lg'"></i>
          </button>
            <!--logo start-->
            <img @click="Dashbord('Home')" class="w-32 max-sm:w-28 cursor-pointer" src="../../../assets/img/logo.png" alt="">
          <!--logo end-->
          <span v-if="titleDashbord !=='Afficher'" class="font-semibold text-xl ml-7 cursor-pointer max-md:hidden">
            {{ titleDashbord }}
          </span>
        </div>
          <!--container end-->
          <!--container start-->
        <div class="flex items-center gap-6 max-md:gap-5">
          <!--button notisication-->
          <button @click="toggleMenuNotifi" class="flex relative">
            <div class="bg-red-600 text-white text-xs rounded-full w-4 h-4 flex justify-center items-center absolute -right-2 top-1">
              {{TotaleNotification}}
            </div>
            <i class="fa-solid fa-bell text-2xl max-sm:text-lg cursor"></i>
            <!-- menu -->
             <AppNotification @messageToParent="handleMessage" class="overflow-hidden " :style="{transition: 'all 1s ease',height:MenuNotifiHeight ,padding:MenuNotifiPadding ,borderWidth:MenuNotifiBorder}"/>
          </button>
          <!--profile-->
          <div @click="toggleMenu" class="flex justify-center items-center gap-2 mr-4 max-md:mr-0 relative cursor-pointer">
            <span class="font-semibold cursor-pointer">{{ user_name }}</span>
            <div v-if="user_name==''" class="w-12 h-3 bg-slate-400/30 animate-pulse rounded-sm"></div>
            <!--logo profile-->
            <div v-if="user_name !==''" class="bg-green-100 flex justify-center items-center h-10 max-sm:h-9 w-10 max-sm:w-9 max rounded-full shadow-sm border cursor-pointer">{{ logo }}</div>
            <div v-if="user_name==''" class="bg-slate-400/30 animate-pulse h-10 max-sm:h-9 w-10 max-sm:w-9 max rounded-full shadow-sm"></div>
            <!--menu profile-->
            <div id="profileMenu" class="absolute flex flex-col gap-1 bg-white shadow-md top-12 right-1 h-0 overflow-hidden hover:h-auto px-5" :style="{ height: menuHeight, transition: 'all 1s ease', paddingTop:menuPadding ,borderWidth:menuBorder, borderColor: '#FFF5E4', borderStyle: 'solid'}">
              <span @click="Dashbordtitle('Profile')" class="px-2 py-1 bg-zinc-100 hover:bg-zinc-200 rounded-md cursor-pointer">Profile</span>
              <span @click="logOut" class="px-2 py-1 text-nowrap bg-zinc-100 hover:bg-zinc-200 rounded-md hidden max-sm:flex cursor-pointer">Se deconnecter</span>
              <span v-if="Permissions_roles.roles =='admin'" @click="Dashbordtitle('Parametre')" class="px-2 py-1 bg-zinc-100 hover:bg-zinc-200 rounded-md cursor-pointer">Parametre</span>
            </div>
          </div>
        </div>
          <!--container end-->
      </header>
      <!--heder end-->
</template>
