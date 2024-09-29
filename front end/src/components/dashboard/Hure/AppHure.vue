<script setup>
// Import from external libraries
import { ref } from 'vue';
// Import local components
import AppNote from '../Note/AppNote.vue';

const Study = ref(25);
const breakTime = ref(0);
const deg = ref(0);
const isPlaying = ref(false);
let studyInterval = null;
let breakTimeInterval = null;
let timerInterval = null;
let timerSegond = ref(0);
let timerMinute = ref(0);
let audio = new Audio('../../../assets/sound/Ba Dum Tss Sound Effect.mp3');
let iconStart = ref('fa-solid fa-play');

const formatTime = (value) => {
  return String(value).padStart(2, '0');
};

const setTimer = () => {
  timerInterval = setInterval(() => {
    timerSegond.value += 1;
    if (timerSegond.value === 60) {
      timerSegond.value = 0;
      timerMinute.value += 1;
    }
  }, 1000);
};

const startStudyTimer = () => {
  timerSegond.value = 0;
  timerMinute.value = 0;
  
  studyInterval = setInterval(() => {
    deg.value += 14.4; 
    Study.value -= 1;
    
    if (Study.value === 0) {
      clearInterval(studyInterval);
      deg.value = 0;
      breakTime.value = 5;
      audio.play();
      startBreakTimer();
    }
  }, 60000); // 1 minute intervals
};

const startBreakTimer = () => {
  timerSegond.value = 0;
  timerMinute.value = 0;
  
  breakTimeInterval = setInterval(() => {
    deg.value += 72; // 360 degrees / 5 minutes = 72 degrees per minute
    breakTime.value -= 1;

    if (breakTime.value === 0) {
      clearInterval(breakTimeInterval);
      deg.value = 0;
      audio.play();
      Study.value = 25;
    }
  }, 60000); // 1 minute intervals
};

const play = () => {
  if (!isPlaying.value) {
    isPlaying.value = true;
    startStudyTimer();
    setTimer();
    iconStart.value = 'fa-solid fa-rotate-right';
  } else {
    isPlaying.value = false;
    clearInterval(breakTimeInterval);
    clearInterval(studyInterval);
    clearInterval(timerInterval);
    timerSegond.value = 0;
    timerMinute.value = 0;
    iconStart.value = 'fa-solid fa-play';
  }
};
</script>

<template>
  <div
    class="bg-white mx-8 max-md:mx-5 mt-5 rounded-lg border shadow-md py-4 px-7 max-md:px-3 flex justify-evenly max-md:flex-col max-md:items-center gap-5"
  >
    <!-- clock start -->
    <div
      :style="'background: conic-gradient(#9af6f7 ' + deg + 'deg, #e6e6e6 0deg);'"
      class="relative border border-black/30 w-36 h-36 mt-9 flex justify-center items-center flex-col rounded-full shadow-md"
    >
      <h3 class="font-semibold text-slate-600">POMODORO</h3>
      <span class="text-2xl">{{ formatTime(timerMinute) }}:{{ formatTime(timerSegond) }}</span>
      <div class="absolute -bottom-9">
        <div @click="play" class="text-lg mt-1 font-semibold scale-105 text-slate-800">
          <i :class="iconStart"></i>
        </div>
      </div>
    </div>
    <!-- clock end -->
    <div class="w-1/2 max-md:w-full max-md:mt-5">
      <AppNote />
    </div>
  </div>
</template>
