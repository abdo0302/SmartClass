// src/services/ablyService.js
import { Realtime } from 'ably';

const ably = new Realtime('eIFL9g.h0G__w:dSaPMDVLyRwHrcsSiq24mMIxVIAhbJBqjcVJpe6KtkI');

const channel = ably.channels.get('shared-channel');

// الاشتراك في جميع الرسائل على القناة
channel.subscribe((message) => {
  console.log('Received message on shared-channel:', message.data);
});
