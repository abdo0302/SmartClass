// Import from external libraries
import axios from 'axios';

const API_KEY = '494dc22e38f4518218225c7de1865a2e96bf93b168a53f24436ff6622699d363'; // Replace with your Daily.co API key
const API_URL = 'https://api.daily.co/v1/rooms';

export const createRoom = async (roomName) => {
  try {
    const response = await axios.post(
      API_URL,
      {
        properties: {
          room_name: roomName,
          enable_chat: true,
          enable_screen_sharing: true,
        },
      },
      {
        headers: {
          Authorization: `Bearer ${API_KEY}`,
          'Content-Type': 'application/json',
        },
      }
    );
    return response.data;
  } catch (error) {
    console.error('Error creating room:', error);
    throw error;
  }
};
