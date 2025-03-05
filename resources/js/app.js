import './bootstrap';
import '../css/app.css';


import { createApp } from 'vue';
import AudioPlayer from './components/AudioPlayer.vue';

const app = createApp({});
app.component('audio-player', AudioPlayer);
app.mount('#app');

