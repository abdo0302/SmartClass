<!-- <template>
    <div class="bg-slate-400 absolute z-50">
      <input class="" v-model="message" placeholder="Type a message" />
      <button @click="sendMessage">Send</button>
      <ul>
        <li v-for="msg in messages" :key="msg">{{ msg }}</li>
      </ul>
    </div>
  </template>
  
  <script>
  import { sendMessage, subscribeToMessages } from '../assets/services/ablyService';
  
  export default {
    data() {
      return {
        message: '',
        messages: []
      };
    },
    methods: {
      sendMessage() {
        sendMessage(this.message);
        this.message = '';
      }
    },
    mounted() {
      subscribeToMessages((msg) => {
        this.messages.push(msg);
      });
    }
  };
  </script>
  
  <style>
  /* Add some basic styling */
  </style> -->
  