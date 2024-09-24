<script setup>
import AppTable from './AppTable.vue';
import AppBarChart from './AppBarChart.vue';
import { computed,onMounted} from 'vue';
import { useStore } from 'vuex';
const store = useStore();
const Statistique=computed(()=>store.getters.getStatistique);
onMounted(() => {
    store.dispatch('getstatistique');
});
</script>
<template>
    <div v-if="Statistique ==''" class="w-full mt-9 flex justify-center items-center h-52">
        <img class="w-36" src="../../../assets/img/load-32_256.gif" alt="">
      </div>
    <div v-else class="flex m-5 gap-4 max-md:flex-col">
        <AppBarChart/>
        <AppTable/>
    </div>
</template>