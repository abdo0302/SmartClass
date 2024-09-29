<script setup>
// Import from external libraries
import { useStore } from 'vuex';
import { computed ,ref ,watch } from 'vue';
// Import local components
import AlertMessage from '../Alerts/AlertMessage.vue';

  // Initialize the store 
  const store = useStore();
  const User_info=computed(()=>store.getters.getUser);
  const Permissions_roles=computed(() => store.getters.getPermissions_roles);
  let logo=ref('');
  let user=ref('');
  user.value=User_info.value.name;
  const showMessage=ref(false);
  let NawUser={name:User_info.value.name, email:User_info.value.email, password:'', password_confirmation:''};
  const Message=computed(()=>store.getters.getMessage);


  for(let i=0;i<2;i++){
    logo.value+=user.value[i].toUpperCase()
  }

  const modifierProfile=()=>{
      showMessage.value=true;
      store.dispatch('UserUpdate',NawUser)
      store.dispatch('me')
  }

  
  watch(Message, (newmessage) => {
  if (newmessage !== '') {
    setTimeout(()=>{
      showMessage.value=false
    },1500);
  }
});  

const DeleteAccount=(id)=>{
   store.dispatch('UserDelet',id)
}
</script>
<template>
    <div class="mx-5 mt-3 flex justify-center flex-col items-center">
        <!-- card start -->
        <div class="bg-white py-3 px-4 shadow-md w-1/2 max-md:w-full mx-28 flex justify-center rounded-xl">
            <!-- countinar -->
            <div class="flex justify-center items-center w-full gap-3">
                <!-- logo name -->
                <div class="bg-teal-200 rounded-full w-9 h-9 flex justify-center items-center border shadow-sm">
                    {{ logo }}
                </div>
                <!-- countinar name end role -->
                <div class="flex flex-col">
                    <span class="text-lg font-semibold">{{ User_info.name }}</span>
                    <span v-for="(Permissions_role,i) in Permissions_roles.roles" :key="i" class="text-bas">Role: <span>{{ Permissions_role }}</span></span>
                </div>
                <!-- button delet account -->
                <button @click="DeleteAccount(User_info.id)" class="mt-auto ml-auto text-xs bg-red-500 text-white p-2 rounded-md shadow-md hover:shadow-none">Delete Account</button>
            </div>
        </div>
         <!-- card end -->
          <!-- card start -->
          <div class="bg-white py-3 px-6 shadow-md w-1/2 max-md:w-full mx-28 flex flex-col rounded-xl mt-3 gap-5">
            <!-- name -->
              <div class="flex flex-col">
                 <label class="font-medium">Name</label>
                 <input v-model="NawUser.name" class="border-2 rounded-lg p-1" type="text" placeholder="Name">
              </div>
              <!-- email -->
              <div class="flex flex-col">
                 <label class="font-medium">Email</label>
                 <input v-model="NawUser.email" class="border-2 rounded-lg p-1" type="text" placeholder="Email">
              </div>
              <!-- password -->
              <div class="flex flex-col">
                 <label class="font-medium">Password</label>
                 <input v-model="NawUser.password" class="border-2 rounded-lg p-1" type="password" placeholder="Password">
              </div>
              <!-- password confirm-->
              <div class="flex flex-col">
                 <label class="font-medium">Confirm Password</label>
                 <input v-model="NawUser.password_confirmation" class="border-2 rounded-lg p-1" type="password" placeholder="Confirm Password">
              </div>
          </div>
          <!-- card end -->
           <!-- button enregistreur -->
            <div class="w-1/2 mr-auto flex justify-center mb-40">
               <button @click="modifierProfile" class="mt-7 mr-24 p-2 bg-blue-500 text-white rounded-lg">Enregistreur</button> 
            </div>
            <AlertMessage v-if="showMessage==true"/>
    </div>
</template>