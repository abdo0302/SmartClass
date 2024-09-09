<script setup>
  import { useStore } from 'vuex';
  import { computed } from 'vue';
  import { ref,watch } from 'vue';
const store = useStore();
const message=computed(()=>store.getters.getMessage);
const loding=ref(true);
watch(message, (newmessage) => {
  if (newmessage !== '') {
    loding.value = false;
  }else{
    loding.value = true;
  }
});
</script>
<template>
    <div class="bg-black/70 w-full h-full fixed top-0 left-0 z-50 flex justify-center items-center">
        <div class="bg-white p-5 rounded-md">
            <img v-if="loding==true" class="w-7 animate-spin" src="../../../assets/img/pngwing.com (12).png" alt="">
            <div v-if="loding!==true">
                {{ message }}
            </div>
            
        </div>
    </div>
</template>