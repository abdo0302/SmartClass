<script setup>
import { useStore } from 'vuex';
import { watch, computed, onUnmounted, onMounted } from 'vue';
import Chart from 'chart.js/auto';

const store = useStore();
let chartInstance = null; // Variable pour stocker l'instance du graphique

const lesClasses = computed(() => store.getters.getClasses);

// Fonction pour détruire le graphique si nécessaire
const destroyChart = () => {
  if (chartInstance) {
    chartInstance.destroy();
    chartInstance = null;
  }
};

// Fonction pour créer le graphique
const createChart = (classes, eleves) => {
  const NameClas = classes.map((e) => e.name);

  const colors = classes.map(() => {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    return `rgb(${r}, ${g}, ${b})`;
  });

  const ctx = document.getElementById('myChart').getContext('2d');
  chartInstance = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: NameClas,
      datasets: [
        {
          label: 'Total des élèves',
          data: eleves,
          backgroundColor: colors,
          hoverOffset: 4,
        },
      ],
    },
  });
};

// Observer les changements dans les classes et créer/détruire le graphique
onMounted(() => {
  if (lesClasses.value.Classes) {
    const elevesData = lesClasses.value.eleve;
    createChart(lesClasses.value.Classes, elevesData);
  }
});

// Regarder les changements dans `lesClasses` pour recréer le graphique
watch(lesClasses, (newlesClasses) => {
  if (newlesClasses.Classes && newlesClasses.eleve) {
    destroyChart(); // Détruire l'ancien graphique
    createChart(newlesClasses.Classes, newlesClasses.eleve); // Créer un nouveau graphique
  }
});

// Détruire le graphique lorsque le composant est démonté
onUnmounted(() => {
  destroyChart();
});
</script>

<template>
  <div class="w-full bg-white rounded-xl shadow-xl py-3 px-5 mb-20">
    <div class="flex">
      <canvas id="myChart"></canvas>
    </div>
  </div>
</template>
