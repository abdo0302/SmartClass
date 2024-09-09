<script setup>
import { useStore } from 'vuex';
const store = useStore();
import { watch,computed } from 'vue';
import Chart from 'chart.js/auto';
const lesClasses=computed(()=>store.getters.getClasses);
// chart js

watch(lesClasses, (newlesClasses) => {
   if (newlesClasses !== '') {
    const NameClas=lesClasses.value.Classes.map((e)=>e.name)
    
    const colors = lesClasses.value.Classes.map(() => {
    const r = Math.floor(Math.random() * 256); 
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);

    return `rgb(${r}, ${g}, ${b})`;
   });
   
      const ctx = document.getElementById('myChart');
      new Chart(ctx, {
            type: 'doughnut',
            data: {labels:NameClas ,
        datasets: [{
            label: 'total de eleve',
            data: newlesClasses.eleve,
            backgroundColor: colors,
            hoverOffset: 4
        }]},});
   }
});  

   
</script>
<template>
    <div class="w-full bg-white rounded-xl shadow-xl py-3 px-5">
         <div class="flex">
            <canvas class="" id="myChart"></canvas>
         </div>
        </div>
</template>