<script setup>
// Import from external libraries
  import { useStore } from 'vuex';

  // Initialize the store
  const store = useStore();

// Function to update the authentication form state
  const Form=(value)=>{
    store.commit('setAuthForm',value);
  }
</script>
<template>
    <header class="fixed w-full shadow-md">
        <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
                <img class="w-32" src="../../assets/img/logo.png" alt="">
                <div class="flex items-center lg:order-2 gap-4">
                    <button @click="Form('sinup')" class="font-semibold hover:text-blue-700">S'inscrire</button>
                    <button @click="Form('login')" class="bg-blue-700 text-white p-2 rounded-xl font-semibold hover:bg-blue-600">Se connecter</button>
                </div>
            </div>
        </nav>
    </header>
</template>