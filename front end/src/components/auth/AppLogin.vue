<script setup>
// Import from external libraries
  import { useStore } from 'vuex';

// Initialize the store 
  const store = useStore();

// Function to update the authentication form state  
  const closeForm=()=>{
     store.commit('setAuthForm','')
   }
</script>
<template>
    <section class="bg-black/70 w-full h-screen fixed top-0 left-0 flex justify-center items-center">
        <div class="relative w-1/3 border-[20px] border-transparent rounded-[20px] bg-white shadow-lg xl:p-8 2xl:p-10 lg:p-8 md:p-8 sm:p-2 m-2">
            <button @click="closeForm" class="absolute -right-1 -top-3 hover:bg-slate-200 px-2 py-1 rounded-full">
                <i class="fa-solid fa-x"></i>
             </button>
            <h1 class="pb-6 font-bold text-4xl text-center cursor-default">Se connecter</h1>
          <form action="#" method="post" class="space-y-4">
            <div>
              <label for="email" class="mb-2 text-lg">Email</label>
              <input id="email" class="border p-3 placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="email" placeholder="Email" required />
            </div>
            <div>
              <label for="password" class="mb-2 text-lg">Password</label>
              <input id="password" class="border p-3 shadow-md placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="password" placeholder="Password" required/>
            </div>
            <a class="group text-blue-400 transition-all duration-100 ease-in-out" href="#">
              <span class="bg-left-bottom bg-gradient-to-r text-sm from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">Forget your password?</span>
            </a>
            <button class="bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg mt-6 p-2 text-white rounded-lg w-full hover:scale-105 hover:from-purple-500 hover:to-blue-500 transition duration-300 ease-in-out" type="submit" >Se connecter</button>
          </form>
          <div class="flex flex-col mt-4 items-center justify-center text-sm">
            <h3 class="dark:text-gray-300">Vous n'avez pas encore de compte?
              <a class="group text-blue-400 transition-all duration-100 ease-in-out" href="#">
                <span class="bg-left-bottom bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">Inscrivez-vous</span>
              </a>
            </h3>
          </div>
          <!-- Third Party Authentication Options -->
          <div id="third-party-auth" class="flex items-center justify-center mt-5 flex-wrap">
            <button href="#" class="flex justify-center items-center gap-2 hover:scale-105 ease-in-out duration-300 shadow-lg p-2 rounded-lg m-1 w-full" >
              <img class="max-w-[25px]" src="https://ucarecdn.com/8f25a2ba-bdcf-4ff1-b596-088f330416ef/" alt="Google"/>
              <span class="font-semibold">Connectez-vous avec Google</span>
            </button>
          </div>
        </div>
    </section>
</template>