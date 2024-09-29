<script setup>
// Import from external libraries
import { computed,onMounted} from 'vue';
import Chart from 'chart.js/auto';
import { useStore } from 'vuex';

  // Initialize the store 
const store = useStore();

const Statistique=computed(()=>store.getters.getStatistique);

onMounted(()=>{
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
    type: 'bar',
    data: {labels: ['Users','Classes','Contenus','Eleve','Devoir'],
    datasets: [{
    label: 'Statistique',
    data: Statistique.value,
    backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(22, 159, 64, 0.2)',
        'rgba(211, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
    ],
    borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
    ],
    borderWidth: 1
    }]},});
});
    
</script>
<template>
    <div class="w-1/2 max-md:w-full max-md:h-52 bg-white p-3 shadow-md rounded-xl flex justify-center items-center">
      <canvas class="" id="myChart"></canvas>
    </div>
</template>