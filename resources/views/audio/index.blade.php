@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Музыка</h1>

        <!-- Кнопка загрузки аудио -->
        <a href="{{ route('audio.create') }}" class="">
        <button class="add-music">
            +
        </button></a>


        <div class="mt-4 mb-6">
            <form action="{{ route('audio.index') }}" method="GET" class="flex items-center space-x-4">
                <!-- Стилизованный выпадающий список для сортировки -->
                <div class="relative">
                    <select name="sort_by" class="appearance-none bg-white border border-gray-300 rounded-lg py-2 pl-4 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 cursor-pointer">
                        <option value="title" {{ $sortBy == 'title' ? 'selected' : '' }}>По названию</option>
                        <option value="artist" {{ $sortBy == 'artist' ? 'selected' : '' }}>По исполнителю</option>
                        <option value="duration" {{ $sortBy == 'duration' ? 'selected' : '' }}>По длительности</option>
                        <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>По дате добавления</option>
                    </select>
                    <!-- Иконка стрелки -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
        
                <!-- Стилизованный выпадающий список для порядка сортировки -->
                <div class="relative">
                    <select name="sort_order" class="appearance-none bg-white border border-gray-300 rounded-lg py-2 pl-4 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 cursor-pointer">
                        <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Сначала старые</option>
                        <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Сначала новые</option>
                    </select>
                    <!-- Иконка стрелки -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
        
                <!-- Кнопка сортировки с анимацией -->
                <button id="sort" type="submit" class="p-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all duration-200 transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-2">
                    Сортировать
                </button>
            </form>
        </div>

        <!-- Список аудиозаписей -->
        <div class="mt-6">
            @foreach ($audios as $audio)
                <div class="audio-item flex items-center p-2 rounded-lg hover:bg-gray-100 transition duration-200 mb-2">
                    <!-- Обложка с кнопкой плей/паузы -->
                    <div class="relative w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                        @if($audio->cover_path)
                            <img src="{{ asset('storage/' . $audio->cover_path) }}" alt="Обложка" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                </svg>
                            </div>
                        @endif
                        <button class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-0 rounded-full w-24 h-24 flex items-center justify-center hover:bg-opacity-90 transition duration-100 play-button" data-audio-id="{{ $audio->id }}" data-playing="false">
                            <!-- Иконка Play -->
                            <img id="play-icon-{{ $audio->id }}" src="{{ asset('./assets/Polygon 2.svg') }}" alt="" class="w-5 h-5">
                            <!-- Иконка Pause (скрыта по умолчанию) -->
                            <img id="pause-icon-{{ $audio->id }}" src="{{ asset('./assets/Group 256.svg') }}" alt="" class="w-5 h-5 hidden">
                        </button>

                    </div>

                    <!-- Скрытый аудио элемент -->
                    <audio id="audio-{{ $audio->id }}" src="{{ asset('storage/' . $audio->file_path) }}" type="audio/mpeg"></audio>

                    <!-- Информация о треке -->
                    <div class="flex-1 ml-3">
                         <!-- Canvas for particle animation -->
                         <div class="flex-1 ml-3">
                            <canvas id="particle-canvas-{{ $audio->id }}" class="absolute top-0 left-0 w-full h-full" style="pointer-events: none;"></canvas>
                            <!-- Остальной контент -->
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-sm font-semibold">{{ $audio->title }}</h2>
                                <p class="text-xs text-gray-600">{{ $audio->artist }}</p>
                            </div>
                            <span id="duration" class="text-xs text-gray-500">{{ $audio->duration }} сек.</span>
                        </div>
                        <div class="relative">
                            <div class="absolute top-0 left-0 h-1 w-0 bg-black rounded-full mt-1 mb-1" id="running-line-{{ $audio->id }}"></div>
                        </div>
                    </div>

                    <!-- Кнопка "Подробнее" -->
                    <a href="{{ route('audio.show', $audio->id) }}" class="text-blue-500 hover:text-blue-600 transition duration-200 ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Прогресс-бар внизу страницы -->
    <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg z-50">
        <div class="container mx-auto px-4 py-2 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Обложка текущего трека -->
                <div id="current-cover-container" class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden hidden">
                    <img id="current-cover" src="" alt="Обложка" class="w-full h-full object-cover">
                </div>
                <!-- Информация о текущем треке -->
                <div>
                    <h2 id="current-title" class="text-lg font-semibold"></h2>
                    <p id="current-artist" class="text-sm text-gray-600"></p>
                </div>
            </div>
            <!-- Прогресс-бар и время -->
            <div class="flex-1 mx-4">
                <div class="flex items-center space-x-2">
                    <span id="current-time" class="text-xs text-gray-500">0:00</span>
                    <input type="range" id="global-progress" class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer" value="0" min="0" max="100">
                    <span id="global-duration" class="text-xs text-gray-500">0:00</span>
                </div>
            </div>
            <!-- Кнопки управления -->
            <div class="flex items-center space-x-4">
                <button id="prev-button" class="bg-black bg-opacity-90 rounded-full p-2 hover:bg-opacity-90 transition duration-200">
                    <img src="{{ asset('./assets/Group 258.svg') }}" alt="Предыдущий" class="w-3 h-3">
                </button>
                <button id="global-play-pause" class="bg-black bg-opacity-90 rounded-full p-2 hover:bg-opacity-90 transition duration-200">
                    <img id="global-play-icon" src="{{ asset('./assets/Polygon 2.svg') }}" alt="" class="w-3 h-3">
                    <img id="global-pause-icon" src="{{ asset('./assets/Group 256.svg') }}" alt="" class="w-3 h-3 hidden">
                </button>
                <button id="next-button" class="bg-black bg-opacity-90 rounded-full p-2 hover:bg-opacity-90 transition duration-200">
                    <img src="{{ asset('./assets/Group 257.svg') }}" alt="Следующий" class="w-3 h-3">
                </button>
            </div>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-button');
        let currentAudioId = null;
        let currentAudioElement = null;
        const globalProgressBar = document.getElementById('global-progress');
        const globalCurrentTime = document.getElementById('current-time');
        const globalDuration = document.getElementById('global-duration');
        const globalPlayPauseButton = document.getElementById('global-play-pause');
        const globalPlayIcon = document.getElementById('global-play-icon');
        const globalPauseIcon = document.getElementById('global-pause-icon');
        const currentCover = document.getElementById('current-cover');
        const currentTitle = document.getElementById('current-title');
        const currentArtist = document.getElementById('current-artist');
        const currentCoverContainer = document.getElementById('current-cover-container');
        const prevButton = document.getElementById('prev-button');
        const nextButton = document.getElementById('next-button');
        let animationFrameId;

        // Particle configuration
        const particlesArray = [];
        const numberOfParticles = 20;
        const particleColor = 'rgba(113, 4, 255, 0.5)'; // Semi-transparent purple

        // Function to reset button icons
        function resetButtonIcons(audioId) {
            const playIcon = document.getElementById(`play-icon-${audioId}`);
            const pauseIcon = document.getElementById(`pause-icon-${audioId}`);

            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        }

        // Function to update progress bar and time
        const updateProgressBar = () => {
            if (currentAudioElement) {
                const currentTimeValue = Math.floor(currentAudioElement.currentTime);
                const durationValue = Math.floor(currentAudioElement.duration);

                // Update current time
                globalCurrentTime.textContent = `${Math.floor(currentTimeValue / 60)}:${String(currentTimeValue % 60).padStart(2, '0')}`;

                // Update progress bar
                const progress = (currentTimeValue / durationValue) * 100;
                globalProgressBar.value = progress;

                // Update overall duration
                if (!isNaN(durationValue)) {
                    globalDuration.textContent = `${Math.floor(durationValue / 60)}:${String(durationValue % 60).padStart(2, '0')}`;
                }

                // Update running line
                const runningLineWidth = progress + '%';
                document.getElementById(`running-line-${currentAudioId}`).style.width = runningLineWidth;
            }
        };

        // Particle class
        class Particle {
            constructor(canvas) {
                this.canvas = canvas;
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = (Math.random() * 3) + 1;
                this.speedX = (Math.random() * 2) - 1.5;
                this.speedY = (Math.random() * 2) - 1.5;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.size > 0.1) this.size -= 0.05;
                if (this.size < 0.1) {
                    this.x = Math.random() * this.canvas.width;
                    this.y = Math.random() * this.canvas.height;
                    this.size = (Math.random() * 3) + 1;
                    this.speedX = (Math.random() * 2) - 1;
                    this.speedY = (Math.random() * 2) - 1;
                }
            }

            draw() {
                const ctx = this.canvas.getContext('2d');
                ctx.fillStyle = particleColor;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.closePath();
                ctx.fill();
            }
        }

        // Initialize particles
        function initParticles(canvas) {
            particlesArray.length = 0;
            for (let i = 0; i < numberOfParticles; i++) {
                particlesArray.push(new Particle(canvas));
            }
        }

        // Animate particles
        function animateParticles(canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particlesArray.forEach(particle => {
                particle.update();
                particle.draw();
            });
            animationFrameId = requestAnimationFrame(() => animateParticles(canvas));
        }

        // Function to play audio
        function playAudio(audioId, button) {
    const audioElement = document.getElementById(`audio-${audioId}`);
    const playIcon = document.getElementById(`play-icon-${audioId}`);
    const pauseIcon = document.getElementById(`pause-icon-${audioId}`);
    const canvas = document.getElementById(`particle-canvas-${audioId}`);

    // Проверка, существует ли canvas
    if (!canvas) {
        console.error(`Canvas with ID particle-canvas-${audioId} not found!`);
        return;
    }

    // Остановить и сбросить, если играет другой трек
    if (currentAudioId !== null && currentAudioId !== audioId) {
        const currentAudioElement = document.getElementById(`audio-${currentAudioId}`);
        currentAudioElement.pause();
        resetButtonIcons(currentAudioId);
        cancelAnimationFrame(animationFrameId); // Отменить анимацию
        const currentPlayButton = document.querySelector(`[data-audio-id="${currentAudioId}"]`);
        currentPlayButton.dataset.playing = 'false';
    }

    // Воспроизвести новый трек
    audioElement.play();
    button.dataset.playing = 'true';
    playIcon.classList.add('hidden');
    pauseIcon.classList.remove('hidden');
    globalPlayIcon.classList.add('hidden');
    globalPauseIcon.classList.remove('hidden');
    currentAudioId = audioId;
    currentAudioElement = audioElement;

    // Обновить информацию о треке
    const audioItem = button.closest('.audio-item');
    const coverImg = audioItem.querySelector('.w-12 img');
    const coverPath = coverImg ? coverImg.src : '';
    const title = audioItem.querySelector('.text-sm').textContent;
    const artist = audioItem.querySelector('.text-xs').textContent;

    currentCover.src = coverPath;
    currentTitle.textContent = title;
    currentArtist.textContent = artist;
    currentCoverContainer.classList.remove('hidden');

    // Инициализация и анимация частиц
    canvas.width = canvas.parentElement.offsetWidth; // Используем родительский элемент для ширины
    canvas.height = canvas.parentElement.offsetHeight; // Используем родительский элемент для высоты
    initParticles(canvas);
    animateParticles(canvas);

    // Установить длительность трека при загрузке
    audioElement.addEventListener('loadedmetadata', () => {
        const durationValue = Math.floor(audioElement.duration);
        if (!isNaN(durationValue)) {
            globalDuration.textContent = `${Math.floor(durationValue / 60)}:${String(durationValue % 60).padStart(2, '0')}`;
        }
    });
}

        // Handle play/pause button click
        playButtons.forEach(button => {
            const audioId = button.dataset.audioId;

            button.addEventListener('click', function() {
                const isPlaying = button.dataset.playing === 'true';
                const audioElement = document.getElementById(`audio-${audioId}`);
                const playIcon = document.getElementById(`play-icon-${audioId}`);
                const pauseIcon = document.getElementById(`pause-icon-${audioId}`);
                const canvas = document.getElementById(`particle-canvas-${audioId}`);

                if (isPlaying) {
                    // Pause audio
                    audioElement.pause();
                    button.dataset.playing = 'false';
                    resetButtonIcons(audioId);
                    globalPlayIcon.classList.remove('hidden');
                    globalPauseIcon.classList.add('hidden');
                    cancelAnimationFrame(animationFrameId); // Stop animation
                } else {
                    // Play audio
                    playAudio(audioId, button);
                }
            });
        });

        // Update progress bar on time update
        document.querySelectorAll('audio').forEach(audioElement => {
            audioElement.addEventListener('timeupdate', updateProgressBar);
        });

        // Seek audio on progress bar input
        globalProgressBar.addEventListener('input', () => {
            if (currentAudioElement) {
                const seekTime = (globalProgressBar.value / 100) * currentAudioElement.duration;
                currentAudioElement.currentTime = seekTime;
                updateProgressBar();
            }
        });

        // Switch to previous track
        prevButton.addEventListener('click', () => {
            if (currentAudioId !== null) {
                const currentIndex = Array.from(playButtons).findIndex(button => button.dataset.audioId === currentAudioId);
                if (currentIndex > 0) {
                    const prevButton = playButtons[currentIndex - 1];
                    prevButton.click();
                }
            }
        });

        // Switch to next track
        nextButton.addEventListener('click', () => {
            if (currentAudioId !== null) {
                const currentIndex = Array.from(playButtons).findIndex(button => button.dataset.audioId === currentAudioId);
                if (currentIndex < playButtons.length - 1) {
                    const nextButton = playButtons[currentIndex + 1];
                    nextButton.click();
                }
            }
        });

        // Toggle play/pause on global button click
        globalPlayPauseButton.addEventListener('click', function() {
            if (currentAudioElement) {
                if (currentAudioElement.paused) {
                    currentAudioElement.play();
                    globalPlayIcon.classList.add('hidden');
                    globalPauseIcon.classList.remove('hidden');
                    const canvas = document.getElementById(`particle-canvas-${currentAudioId}`);
                    animateParticles(canvas);
                } else {
                    currentAudioElement.pause();
                    globalPlayIcon.classList.remove('hidden');
                    globalPauseIcon.classList.add('hidden');
                    cancelAnimationFrame(animationFrameId);
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
    const durationElements = document.querySelectorAll('#duration');

    function secondsToMinutesAndSeconds(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;

        const formattedMinutes = String(minutes).padStart(2, '0');
        const formattedSeconds = String(remainingSeconds).padStart(2, '0');

        return `${formattedMinutes}:${formattedSeconds}`;
    }

    durationElements.forEach(element => {
        const duration = parseInt(element.textContent.replace(' сек.', ''));
        const formattedDuration = secondsToMinutesAndSeconds(duration);
        element.textContent = formattedDuration;
    });
});




</script>

<style>
    input[type="range"] {
           -webkit-appearance: none;
           appearance: none;
           background: #e2e8f0; /* Цвет фона */
           height: 4px;
           border-radius: 2px;
           outline: none;
       }

       input[type="range"]::-webkit-slider-thumb {
           -webkit-appearance: none;
           appearance: none;
           width: 12px;
           height: 12px;
           background: #000000; /* Цвет ползунка */
           border-radius: 10%;
           cursor: pointer;
       }

       input[type="range"]::-moz-range-thumb {
           width: 12px;
           height: 12px;
           background: #3b82f6;
           border-radius: 50%;
           cursor: pointer;
       }

       .audio-container {
           position: relative;
           overflow: hidden;
       }

       .add-music {
    position: fixed;
    bottom: 100px;
    right: 20px;
    width: 40px;
    height: 40px;
    background-color: #3b82f6; 
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    border: none;
    outline: none;
    color: #fff;
}

.add-music a {
    color: white;
    font-size: 18px;
    text-decoration: none;
}

.add-music:hover {
    background-color: #000000; /* Цвет при наведении */
    color: #fff;
}
/* Стили для выпадающих списков */
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: white;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.5rem 2rem 0.5rem 1rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

select:hover {
    border-color: #9ca3af;
}

select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

/* Иконка стрелки */
.relative svg {
    transition: transform 0.2s ease-in-out;
}

select:focus + .relative svg {
    transform: rotate(180deg);
}

/* Кнопка сортировки */
.relative #sort {
    background-color: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}

.relative #sort:hover {
    background-color: #2563eb;
    transform: scale(1.05);
}

.relative #sort:active {
    transform: scale(0.95);
}

#sort:focus {
    border: 1px solid #2563eb;
}
</style>
@endsection
