<template>
  <div>
    <input v-model="roomName" placeholder="Enter room name" />
    <button @click="createRoom">Create Room</button>
    <div v-if="roomUrl">
      <p>Room URL:</p>
      <a :href="roomUrl" target="_blank">{{ roomUrl }}</a>
    </div>
  </div>
</template>

<script>
import { createRoom } from '../services/dailyService';

export default {
  data() {
    return {
      roomName: '',
      roomUrl: '',
    };
  },
  methods: {
    async createRoom() {
      try {
        const result = await createRoom(this.roomName);
        this.roomUrl = result.url; // Adjust based on the API response structure
      } catch (error) {
        console.error('Error creating room:', error);
      }
    },
  },
};
</script>

