<script setup>
import { computed, onUnmounted,defineEmits,ref,watch } from 'vue';
import { useStore } from 'vuex';
import DailyIframe from '@daily-co/daily-js';

// Initialize the store
const store = useStore();
const Roome = computed(() => store.getters.getRoome);
const emit = defineEmits(['messageToParent']);
let callFrame;
const joinCall=ref(false)

const loding=ref(true)
watch(Roome, (newRoome) => {
  if (newRoome !== '') {
        // Create the call frame
    callFrame = DailyIframe.createFrame(document.querySelector('#video-container'), {
        url: `https://abdogt.daily.co/${Roome.value}`,
        iframeStyle: {
            width: '100%',
            height: '100%',
            border: 'none'
        }
    });

    // Join the call
    callFrame.join().then(() => {
        joinCall.value=true
    }).catch((error) => {
        console.error('Error joining the call:', error);
    });
    loding.value=false
  }
}); 

onUnmounted(() => {
    // Leave the call and destroy the call frame
    if (callFrame) {
        callFrame.leave().then(() => {
            callFrame.destroy();
        }).catch((error) => {
            console.error('Error leaving the call:', error);
        });
    }
});
const leaveCall=()=>{
    callFrame.leave()
    emit('messageToParent', false);
}
</script>

<template>
    
    
    <div id="video-container" class="absolute z-50 top-0 left-0 w-full bg-white h-screen">
        <!-- Video call will be embedded here -->
         <div v-if="loding==true" class="w-full h-screen flex justify-center items-center">
            <img class="w-32" src="../../../assets/img/load-32_256.gif" alt="">
        </div>
    </div>
    <button v-if="joinCall==true" @click="leaveCall" class="bg-red-500 py-2 px-5 rounded-xl shadow-xl hover:shadow-none absolute bottom-2 right-5 z-50"><i class="fa-solid fa-phone-slash text-white text-base"></i></button>
</template>
