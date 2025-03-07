<template>
    <div class="audio-player">
        <!-- Аудио элемент -->
        <audio ref="audio" :src="audioSrc" @timeupdate="updateProgress" @loadedmetadata="setDuration" @play="onPlay" @pause="onPause"></audio>

        <!-- Обложка -->
        <img v-if="coverSrc" :src="coverSrc" alt="Обложка" class="cover-image" :class="{ 'cover-animate': isPlaying }">

        <!-- Визуализация звука -->
        <div class="visualizer">
            <canvas ref="visualizer" class="visualizer-canvas"></canvas>
        </div>

        <!-- Прогресс-бар -->
        <div class="progress-bar">
            <span class="time">{{ currentTimeFormatted }}</span>
            <input
                type="range"
                v-model="progress"
                class="progress-range"
                @input="seek"
                @click.stop="handleClickOnProgressBar($event)"
            >
            <span class="time">{{ durationFormatted }}</span>
        </div>

        <!-- Управление воспроизведением -->
        <div class="controls">
            <button @click="togglePlay" class="control-button">
                <PlayIcon v-if="!isPlaying" class="icon" />
                <PauseIcon v-else class="icon" />
            </button>
            <button @click="restart" class="control-button">
                <RefreshIcon class="icon" />
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
        coverSrc: {
            type: String,
            required: false,
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
                this.isPlaying = false;
            } else {
                audio.play();
                this.initVisualizer();
                this.isPlaying = true;
            }
        },
        seek() {
            const audio = this.$refs.audio;
            if (this.audioReady && audio.readyState === 4) {
                setTimeout(() => {
                    audio.currentTime = (this.progress / 100) * this.duration;
                    this.updateProgress();
                }, 50);
            } else {
                setTimeout(() => this.seek(), 100);
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
            });
            this.$refs.audio.addEventListener('timeupdate', () => {
                this.updateProgress();
            });
        },
        formatTime(time) {
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
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

            if (!this.audioContext) {
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
            }

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
        onPlay() {
            this.isPlaying = true;
        },
        onPause() {
            this.isPlaying = false;
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