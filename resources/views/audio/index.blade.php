@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Музыка</h1>

        <!-- Кнопка загрузки аудио -->
        <a href="{{ route('audio.create') }}" class="">
        <button id="add-music" class="fixed bottom-20 right-8 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>            
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
@endsection




<style>
.add-music {
    
}
</style>


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

        // Function to play audio
        function playAudio(audioId, button) {
            const audioElement = document.getElementById(`audio-${audioId}`);
            const playIcon = document.getElementById(`play-icon-${audioId}`);
            const pauseIcon = document.getElementById(`pause-icon-${audioId}`);

            // Остановить и сбросить, если играет другой трек
            if (currentAudioId !== null && currentAudioId !== audioId) {
                const currentAudioElement = document.getElementById(`audio-${currentAudioId}`);
                currentAudioElement.pause();
                resetButtonIcons(currentAudioId);
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
            const coverPath = audioItem.querySelector('img')?.getAttribute('src') || '';
            const title = audioItem.querySelector('.text-sm.font-semibold').textContent;
            const artist = audioItem.querySelector('.text-xs.text-gray-600').textContent;

            currentCover.setAttribute('src', coverPath);
            currentTitle.textContent = title;
            currentArtist.textContent = artist;
            currentCoverContainer.classList.remove('hidden');

            // Обновление прогресс-бара и времени
            audioElement.addEventListener('timeupdate', updateProgressBar);

            // Обработчик окончания воспроизведения
            audioElement.addEventListener('ended', () => {
                resetButtonIcons(audioId);
                button.dataset.playing = 'false';
                globalPlayIcon.classList.remove('hidden');
                globalPauseIcon.classList.add('hidden');
            });
        }

        // Add event listeners to play buttons
        playButtons.forEach(button => {
            button.addEventListener('click', function() {
                const audioId = this.dataset.audioId;
                const isPlaying = this.dataset.playing === 'true';

                if (isPlaying) {
                    // Pause the audio
                    document.getElementById(`audio-${audioId}`).pause();
                    this.dataset.playing = 'false';
                    document.getElementById(`play-icon-${audioId}`).classList.remove('hidden');
                    document.getElementById(`pause-icon-${audioId}`).classList.add('hidden');
                    globalPlayIcon.classList.remove('hidden');
                    globalPauseIcon.classList.add('hidden');
                } else {
                    // Play the audio
                    playAudio(audioId, this);
                }
            });
        });

        // Global play/pause button
        globalPlayPauseButton.addEventListener('click', function() {
            if (currentAudioElement) {
                if (currentAudioElement.paused) {
                    currentAudioElement.play();
                    globalPlayIcon.classList.add('hidden');
                    globalPauseIcon.classList.remove('hidden');
                    document.getElementById(`play-icon-${currentAudioId}`).classList.add('hidden');
                    document.getElementById(`pause-icon-${currentAudioId}`).classList.remove('hidden');
                } else {
                    currentAudioElement.pause();
                    globalPlayIcon.classList.remove('hidden');
                    globalPauseIcon.classList.add('hidden');
                    document.getElementById(`play-icon-${currentAudioId}`).classList.remove('hidden');
                    document.getElementById(`pause-icon-${currentAudioId}`).classList.add('hidden');
                }
            }
        });

        // Progress bar seek functionality
        globalProgressBar.addEventListener('input', function() {
            if (currentAudioElement) {
                const seekTime = currentAudioElement.duration * (this.value / 100);
                currentAudioElement.currentTime = seekTime;
                updateProgressBar();
            }
        });

        // Previous button
        prevButton.addEventListener('click', () => {
            if (currentAudioId !== null) {
                const currentIndex = Array.from(playButtons).findIndex(button => button.dataset.audioId === currentAudioId);
                if (currentIndex > 0) {
                    const prevButton = playButtons[currentIndex - 1];
                    prevButton.click();
                }
            }
        });

  
        nextButton.addEventListener('click', () => {
            if (currentAudioId !== null) {
                const currentIndex = Array.from(playButtons).findIndex(button => button.dataset.audioId === currentAudioId);
                if (currentIndex < playButtons.length - 1) {
                    const nextButton = playButtons[currentIndex + 1];
                    nextButton.click();
                }
            }
        });
    });
</script>
