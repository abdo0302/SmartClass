<script setup>
// Import from external libraries
  import { useStore } from 'vuex';
  import { computed ,onMounted, watch } from 'vue';
    // Initialize the store 
  const store = useStore();

  const Config=computed(()=>store.getters.getConfig);

  onMounted(()=>{
    store.dispatch('getConfig')
  });

  
  const ConfigData={
   MAIL_USERNAME:'',
   MAIL_PASSWORD:'',
   MAIL_FROM_ADDRESS:'',
   DAILY_API_KEY:'',
   ABLY_API_KEY:'',
   DB_DATABASE:'',
   DB_USERNAME:'',
   DB_PASSWORD:'',
  }

  watch(Config,(newConfig)=>{
   ConfigData.MAIL_USERNAME=newConfig.MAIL_USERNAME,
   ConfigData.MAIL_PASSWORD=newConfig.MAIL_PASSWORD,
   ConfigData.MAIL_FROM_ADDRESS=newConfig.MAIL_FROM_ADDRESS,
   ConfigData.DAILY_API_KEY=newConfig.DAILY_API_KEY,
   ConfigData.ABLY_API_KEY=newConfig.ABLY_API_KEY,
   ConfigData.DB_DATABASE=newConfig.DB_DATABASE,
   ConfigData.DB_USERNAME=newConfig.DB_USERNAME,
   ConfigData.DB_PASSWORD=newConfig. DB_PASSWORD
  })

  const updateConfig=()=>{
     store.dispatch('updateConfig',ConfigData)
  }
</script>
<template>
    <div class="flex items-center bg-slate-100 flex-col px-10">
        <div v-if="Config !==''" class="bg-white w-1/2 max-md:w-full mt-4 rounded-xl py-3 px-6 flex flex-col gap-4 shadow-lg border">
            <span class="font-semibold text-lg">Mail</span>
            <div class="flex flex-col ml-3 gap-1">
               <span>MAIL_USERNAME</span>
               <input v-model="ConfigData.MAIL_USERNAME" class="border-2 border-slate-300 rounded-lg py-1 px-2" type="text" placeholder="USERNAME">
            </div>
            <div class="flex flex-col ml-3 gap-1">
               <span>MAIL_PASSWORD</span>
               <input v-model="ConfigData.MAIL_PASSWORD" class="border-2 border-slate-300 rounded-lg py-1 px-2" type="text" placeholder="PASSWORD">
            </div>
            <div class="flex flex-col ml-3 gap-1">
               <span>MAIL_FROM_ADDRESS</span>
               <input v-model="ConfigData.MAIL_FROM_ADDRESS" class="border-2 border-slate-300 rounded-lg py-1 px-2" type="text" placeholder="FROM_ADDRESS">
            </div>
            <span class="font-semibold text-lg mt-5">Api Key</span>
            <div class="flex flex-col ml-3 gap-1">
               <span>DAILY_API_KEY</span>
               <input v-model="ConfigData.DAILY_API_KEY" class="border-2 border-slate-300 rounded-lg py-1 px-2" type="text" placeholder="DAILY_API_KEY">
            </div>
            <div class="flex flex-col ml-3 gap-1">
               <span>ABLY_API_KEY</span>
               <input v-model="ConfigData.ABLY_API_KEY" class="border-2 border-slate-300 rounded-lg py-1 px-2" type="text" placeholder="ABLY_API_KEY">
            </div>
            <span class="font-semibold text-lg mt-5">Database</span>
            <div class="flex flex-col ml-3 gap-1">
               <span>DB_DATABASE</span>
               <input v-model="ConfigData.DB_DATABASE" class="border-2 border-slate-300 rounded-lg py-1 px-2" type="text" placeholder="DB_DATABASE">
            </div>
            <div class="flex flex-col ml-3 gap-1">
               <span>DB_USERNAME</span>
               <input v-model="ConfigData.DB_USERNAME" class="border-2 border-slate-300 rounded-lg py-1 px-2" type="text" placeholder="DB_USERNAME">
            </div>
            <div class="flex flex-col ml-3 gap-1">
               <span>DB_PASSWORD</span>
               <input v-model="ConfigData.DB_PASSWORD" class="border-2 border-slate-300 rounded-lg py-1 px-2" type="text" placeholder="DB_PASSWORD">
            </div>
        </div>
        <div v-if="Config !==''" class="w-1/2 -ml-12 mb-28">
            <button @click="updateConfig" class="mt-5 mr-24 p-2 bg-blue-500 text-white rounded-lg">Enregistreur</button>
        </div>
        <div v-if="Config ==''" class="w-full mt-9 flex justify-center items-center h-52">
           <img class="w-52" src="../../../assets/img/load-32_256.gif" alt="">
        </div>
    </div>
</template>