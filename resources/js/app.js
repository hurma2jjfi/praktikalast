import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import AudioPlayer from './components/AudioPlayer.vue';
import ChatComponent from './components/ChatComponent.vue';



const app = createApp({
    components: {
        AudioPlayer,
        ChatComponent,
    }
});

app.mount('#app');
