<template>
    <div class="bg-gray-100 p-6 rounded-lg">
        <!-- Аудио элемент -->
        <audio ref="audio" :src="audioSrc" @timeupdate="updateProgress" @loadedmetadata="setDuration"></audio>

        <!-- Визуализация звука -->
        <div class="relative h-20 mb-4">
            <canvas ref="visualizer" class="absolute top-0 left-0 w-full h-full"></canvas>
        </div>

        <!-- Прогресс-бар -->
        <div class="flex items-center space-x-4 mb-4">
            <span class="text-sm text-gray-600">{{ currentTimeFormatted }}</span>
            <input 
                type="range" 
                v-model="progress" 
                class="w-full h-2 bg-gray-300 rounded-lg appearance-none cursor-pointer" 
                @input="seek" 
                @click.stop="handleClickOnProgressBar($event)"
            >
            <span class="text-sm text-gray-600">{{ durationFormatted }}</span>
        </div>

        <!-- Управление воспроизведением -->
        <div class="flex justify-center space-x-6">
            <button @click="togglePlay" class="p-3 bg-gray-200 rounded-full hover:bg-gray-300 transition duration-200">
                <PlayIcon v-if="!isPlaying" class="w-6 h-6 text-gray-600" />
                <PauseIcon v-else class="w-6 h-6 text-gray-600" />
            </button>
            <button @click="restart" class="p-3 bg-gray-200 rounded-full hover:bg-gray-300 transition duration-200">
                <RefreshIcon class="w-6 h-6 text-gray-600" />
            </button>
        </div>
    </div>
</template>

<script>
import { PlayIcon, PauseIcon, RefreshIcon } from '@heroicons/vue/solid';

export default {
    components: {
        PlayIcon,
        PauseIcon,
        RefreshIcon,
    },
    props: {
        audioSrc: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            isPlaying: false,
            currentTime: 0,
            duration: 0,
            progress: 0,
            audioContext: null,
            analyser: null,
            dataArray: null,
            canvasCtx: null,
            audioReady: false,
        };
    },
    computed: {
        currentTimeFormatted() {
            return this.formatTime(this.currentTime);
        },
        durationFormatted() {
            return this.formatTime(this.duration);
        },
    },
    methods: {
        togglePlay() {
            const audio = this.$refs.audio;
            if (this.isPlaying) {
                audio.pause();
            } else {
                audio.play();
                this.initVisualizer();
            }
            this.isPlaying = !this.isPlaying;
        },
        seek() {
            const audio = this.$refs.audio;
            if (this.audioReady && audio.readyState === 4) {
                console.log('Перемотка на:', (this.progress / 100) * this.duration);
                // Добавление небольшой задержки перед перемоткой
                setTimeout(() => {
                    audio.currentTime = (this.progress / 100) * this.duration;
                    console.log('Текущее время после перемотки:', audio.currentTime);
                    // Обновление прогресс-бара сразу после перемотки
                    this.updateProgress();
                }, 50); // Задержка в 50 мс
            } else {
                console.log('Аудио не готово к перемотке');
                setTimeout(() => this.seek(), 100); // Повторная попытка через 100 мс
            }
        },

        updateProgress() {
            const audio = this.$refs.audio;
            this.currentTime = audio.currentTime;
            this.progress = (audio.currentTime / this.duration) * 100;
        },
        setDuration() {
            this.duration = this.$refs.audio.duration;
            this.$refs.audio.addEventListener('canplaythrough', () => {
                this.audioReady = true;
                console.log('Аудио готово к перемотке');
            });
            // Обновление прогресс-бара при изменении времени воспроизведения
            this.$refs.audio.addEventListener('timeupdate', () => {
                this.updateProgress();
            });
        },

        formatTime(time) {
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        },
        restart() {
            const audio = this.$refs.audio;
            audio.currentTime = 0;
            if (!this.isPlaying) {
                audio.play();
                this.isPlaying = true;
            }
        },
        initVisualizer() {
            const audio = this.$refs.audio;
            const canvas = this.$refs.visualizer;

            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
            this.analyser = this.audioContext.createAnalyser();
            const source = this.audioContext.createMediaElementSource(audio);
            source.connect(this.analyser);
            this.analyser.connect(this.audioContext.destination);

            this.analyser.fftSize = 256;
            const bufferLength = this.analyser.frequencyBinCount;
            this.dataArray = new Uint8Array(bufferLength);

            this.canvasCtx = canvas.getContext('2d');
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;

            this.drawVisualizer();
        },
        drawVisualizer() {
            if (!this.isPlaying) return;

            const canvas = this.$refs.visualizer;
            const width = canvas.width;
            const height = canvas.height;

            requestAnimationFrame(this.drawVisualizer);

            this.analyser.getByteFrequencyData(this.dataArray);

            this.canvasCtx.fillStyle = 'rgb(255, 255, 255)';
            this.canvasCtx.fillRect(0, 0, width, height);

            const barWidth = (width / this.dataArray.length) * 2.5;
            let x = 0;

            for (let i = 0; i < this.dataArray.length; i++) {
                const barHeight = this.dataArray[i] / 2;

                this.canvasCtx.fillStyle = `rgb(113, 4, 255, ${barHeight / 256})`;
                this.canvasCtx.fillRect(x, height - barHeight, barWidth, barHeight);

                x += barWidth + 1;
            }
        },
        handleClickOnProgressBar(event) {
            const rect = event.target.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const progress = (x / event.target.offsetWidth) * 100;
            this.progress = progress;
            this.seek();
        },
    },
    beforeUnmount() {
        if (this.audioContext) {
            this.audioContext.close();
            this.audioContext = null;
        }
        if (this.canvasCtx) {
            this.canvasCtx.clearRect(0, 0, this.$refs.visualizer.width, this.$refs.visualizer.height);
            this.canvasCtx = null;
        }
    },
};
</script>
