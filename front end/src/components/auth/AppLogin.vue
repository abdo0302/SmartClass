<script setup>
// Import from external libraries
  import { useStore } from 'vuex';
  import { computed, ref , watch } from 'vue';

// Initialize the store 
  const store = useStore();
  
  const user={email:'', password:'',} 
  let error=computed(() => store.getters.getAuth);
  let loging=ref(false);

// Function SignIn
   const signIn=()=>{
    loging.value=true
    store.commit('setAuth','')
    store.dispatch('signIn',user)
   }

   // Watch the error state to reset loading
   watch(error, (newError) => {
  if (newError !== '') {
    loging.value = false;
  }
});

</script>
<template>
    <section class="contenar bg-black/5 w-full h-screen fixed top-0 left-0 flex justify-center items-center z-50">
        <div class="relative w-1/3 max-lg:w-1/2 max-md:w-full mx-8 border-[20px] border-transparent rounded-[20px] bg-white shadow-xl xl:p-8 2xl:p-10 lg:p-8 md:p-8 sm:p-2 m-2">
            <h1 class="pb-6 font-bold text-4xl max-md:text-2xl text-center cursor-default">Se connecter</h1>
            <span class="text-red-500 text-center w-full block">{{error}}</span>
           <form @submit.prevent="signIn" class="space-y-4">
            <div>
              <label for="email" class="mb-2 text-lg">Email</label>
              <input v-model="user.email" id="email" class="border p-3 placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="email" placeholder="Email" required />
            </div>
            <div>
              <label for="password" class="mb-2 text-lg">Password</label>
              <input v-model="user.password" id="password" class="border p-3 shadow-md placeholder:text-base focus:scale-105 ease-in-out duration-300 border-gray-300 rounded-lg w-full" type="password" placeholder="Password" required/>
            </div>
            <button class="bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg p-2 text-white rounded-lg w-full hover:scale-105 hover:from-purple-500 hover:to-blue-500 transition duration-300 ease-in-out flex justify-center items-center gap-2" type="submit" >Se connecter <img v-if="loging==true" class="w-7 animate-spin" src="../../assets/img/pngwing.com (12).png" alt=""></button>
          </form>
        </div>
    </section>
</template>
<style>
.contenar{
  background-image: url(../../assets/img/background-simplon-pattern.svg);
}
</style>