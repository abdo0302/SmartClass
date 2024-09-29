<script setup>
// Import from external libraries
import { useStore } from 'vuex';
import { computed , watch } from 'vue';
import { ref } from 'vue';

// Initialize the store 
  const store = useStore();
  
  const user={name:'', email:'', password:'', password_confirmation:'', role:''}
  let error=computed(() => store.getters.getAuth);
  let loging=ref(false);

  // Function Show Form (LogIn , SinUp)
  const Frm=(value)=>{
    store.commit('setAuthForm',value)
  }
// Function to update the authentication form state  
  const closeForm=()=>{
    store.commit('setAuth','')
     store.commit('setAuthForm','')
   }
   
   // Function SignUp
   const signUp=()=>{
    loging.value=true
    store.commit('setAuth','')
    store.dispatch('signUp',user)
   }

 // Watch the error state to reset loading
   watch(error, (newError) => {
  if (newError !== '') {
    loging.value = false;
  }
});
</script>
<template>
    <section class="bg-black/70 w-full h-screen fixed top-0 left-0 flex justify-center items-center z-50">
        <div class="w-1/3 max-lg:w-1/2 max-md:w-full mx-8 relative border-[20px] border-transparent rounded-[20px] bg-white shadow-lg px-4">
             <button @click="closeForm" class="absolute -right-1 -top-3 hover:bg-slate-200 px-2 py-1 rounded-full">
                <i class="fa-solid fa-x"></i>
             </button>
            <h1 class="pb-4 font-bold text-3xl text-center cursor-default max-md:text-2xl">S'inscrire</h1>
            <span class="text-red-500 text-center w-full block">{{error}}</span>
            <form @submit.prevent="signUp" class="space-y-2 mt-4 max-md:mt-1">
            <div>
              <label for="Name" class="mb-1 text-lg max-md:text-base">Name</label>
              <input v-model="user.name" id="Name" class="border p-2 max-md:p-1 placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="text" placeholder="Name" required />
            </div>
            <div>
              <label for="email" class="mb-1 text-lg max-md:text-base">Email</label>
              <input v-model="user.email" id="email" class="border p-2 max-md:p-1 placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="email" placeholder="Email" required />
            </div>
            <div>
              <label for="password" class="mb-1 text-lg max-md:text-base">Password</label>
              <input v-model="user.password" id="password" class="border p-2 max-md:p-1 shadow-md placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="password" placeholder="Password" required/>
            </div>
            <div>
              <label for="password_Confirm" class="mb-1 text-lg max-md:text-base">Confirm Password</label>
              <input v-model="user.password_confirmation" id="password-Confirm" class="border p-2 max-md:p-1 shadow-md placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="password" placeholder="Confirm Password" required/>
            </div>
            <div>
                <select v-model="user.role" name="role" id="role" class="border p-1 mt-1 mb-1 shadow-md">
                  <option value="" selected disabled hidden>Choisissez le rôle</option>
                  <option value="eleve">eleve</option>
                  <option value="professeur">professeur</option>
                </select>
            </div>
            <button class="bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg mt-6 p-2 max-md:p-1 text-white rounded-lg w-full hover:scale-105 hover:from-purple-500 hover:to-blue-500 transition duration-300 ease-in-out flex justify-center items-center gap-2" type="submit" >S'inscrire <img v-if="loging==true" class="w-7 animate-spin" src="../../assets/img/pngwing.com (12).png" alt=""></button>
          </form>
          <div class="flex flex-col mt-3 items-center justify-center text-sm">
            <h3 class="dark:text-gray-300 max-md:text-xs">Vous avez déjà un compte ?
              <a class="group text-blue-400 transition-all duration-100 ease-in-out" href="#">
                <span @click="Frm('login')" class="bg-left-bottom bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">Connectez-vous</span>
              </a>
            </h3>
          </div>
        </div>
    </section>
</template>