<script setup>
import { Realtime } from 'ably';
import { ref, computed, watch, onUnmounted ,defineEmits } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const emit = defineEmits(['messageToParent']);
// Initialize Ably
const ably = new Realtime('eIFL9g.h0G__w:dSaPMDVLyRwHrcsSiq24mMIxVIAhbJBqjcVJpe6KtkI');

// Get user info from store
const User_info = computed(() => store.getters.getUser);

let channel = ref(null);
const messages = ref([]);

// Subscribe to channel messages
watch(User_info, (newUserInfo) => {
  // Unsubscribe from the old channel if it exists
  if (channel.value) {
    channel.value.unsubscribe();
  }

  // Subscribe to the new channel
  if (newUserInfo && newUserInfo.token) {
    channel.value = ably.channels.get(newUserInfo.token);

    channel.value.subscribe((message) => {
      messages.value.push(message.data);
      emit('messageToParent', messages.value.length);
    });
  }
});

// Clean up the channel on component unmount
onUnmounted(() => {
  if (channel.value) {
    channel.value.unsubscribe();
  }
});

// Function to remove a message by its index
const supprimerMessage = (index) => {
  messages.value.splice(index, 1);
  emit('messageToParent', messages.value.length);
};

</script>

<template>
  <div class="absolute top-8 -right-16 p-2 border-2 bg-white rounded-md shadow-md w-64 h-72 overflow-y-auto flex flex-col gap-2">
    <span v-for="(message, i) in messages" :key="i" class="flex items-center gap-4 border bg-stone-100 p-2 rounded-lg relative text-sm text-start">
      <img class="bg-slate-200 rounded-full w-10 p-1 border border-slate-400" src="../../../assets/img/megaphone.gif" alt="">
      <i @click="supprimerMessage(i)" class="fa-solid fa-x absolute top-1 right-1.5 text-xs bg-white w-5 h-5 flex justify-center items-center rounded-full hover:bg-blue-500 hover:text-white cursor-pointer"></i>
      {{ message}}
    </span>
    <div v-if="messages==''" class="h-full flex justify-center items-center">
      <img class="absolute z-10" src="../../../assets/img/bg_notification.png" alt="">
      <span class="text-sm font-bold z-20">Vous n’avez pas de notification</span>
    </div>
  </div>
</template>

<style>
/* Add your styles here if needed */
</style>
