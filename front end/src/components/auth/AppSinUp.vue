<script setup>
// Import from external libraries
import { useStore } from 'vuex';
import { computed , watch } from 'vue';
import { ref } from 'vue';

// Initialize the store 
  const store = useStore();
  const Frm=(value)=>{
    store.commit('setAuthForm',value)
  }
// Function to update the authentication form state  
  const closeForm=()=>{
    store.commit('setAuth','')
     store.commit('setAuthForm','')
   }
   const user={
    name:'',
    email:'',
    password:'',
    password_confirmation:'',
    role:''
   }
   let error=computed(() => store.getters.getAuth);
   let loging=ref(false);
   const signUp=()=>{
    loging.value=true
    store.commit('setAuth','')
    store.dispatch('signUp',user)
   }
   watch(error, (newError) => {
  if (newError !== '') {
    loging.value = false;
  }
});
</script>
<template>
    <section class="bg-black/70 w-full h-screen fixed top-0 left-0 flex justify-center items-center">
        <div class="w-4/12 relative border-[20px] border-transparent rounded-[20px] bg-white shadow-lg px-4">
             <button @click="closeForm" class="absolute -right-1 -top-3 hover:bg-slate-200 px-2 py-1 rounded-full">
                <i class="fa-solid fa-x"></i>
             </button>
            <h1 class="pb-4 font-bold text-3xl text-center cursor-default">S'inscrire</h1>
            <span class="text-red-500 text-center w-full block">{{error}}</span>
            <form @submit.prevent="signUp" class="space-y-2 mt-4">
            <div>
              <label for="Name" class="mb-1 text-lg">Name</label>
              <input v-model="user.name" id="Name" class="border p-2 placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="text" placeholder="Name" required />
            </div>
            <div>
              <label for="email" class="mb-1 text-lg">Email</label>
              <input v-model="user.email" id="email" class="border p-2 placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="email" placeholder="Email" required />
            </div>
            <div>
              <label for="password" class="mb-1 text-lg">Password</label>
              <input v-model="user.password" id="password" class="border p-2 shadow-md placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="password" placeholder="Password" required/>
            </div>
            <div>
              <label for="password_Confirm" class="mb-1 text-lg">Confirm Password</label>
              <input v-model="user.password_confirmation" id="password-Confirm" class="border p-2 shadow-md placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="password" placeholder="Confirm Password" required/>
            </div>
            <div>
                <select v-model="user.role" name="role" id="role" class="border p-1 mt-1 mb-1 shadow-md">
                  <option value="" selected disabled hidden>Choisissez le rôle</option>
                  <option value="eleve">eleve</option>
                  <option value="professeur">professeur</option>
                </select>
            </div>
            <button class="bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg mt-6 p-2 text-white rounded-lg w-full hover:scale-105 hover:from-purple-500 hover:to-blue-500 transition duration-300 ease-in-out flex justify-center items-center gap-2" type="submit" >S'inscrire <img v-if="loging==true" class="w-7 animate-spin" src="../../assets/img/pngwing.com (12).png" alt=""></button>
          </form>
          <div class="flex flex-col mt-3 items-center justify-center text-sm">
            <h3 class="dark:text-gray-300">Vous avez déjà un compte ?
              <a class="group text-blue-400 transition-all duration-100 ease-in-out" href="#">
                <span @click="Frm('login')" class="bg-left-bottom bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">Connectez-vous</span>
              </a>
            </h3>
          </div>
          <!-- Third Party Authentication Options -->
          <div id="third-party-auth" class="flex items-center justify-center mt-3 flex-wrap">
            <button href="#" class="flex justify-center items-center gap-2 hover:scale-105 ease-in-out duration-300 shadow-lg p-2 rounded-lg m-1 w-full" >
              <img class="max-w-[25px]" src="https://ucarecdn.com/8f25a2ba-bdcf-4ff1-b596-088f330416ef/" alt="Google"/>
              <span class="font-semibold">Inscrivez-vous avec Google</span>
            </button>
          </div>
        </div>
    </section>
</template>