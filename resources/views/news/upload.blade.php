@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Добавить новость</h1>

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Заголовок</label>
            <input type="text" name="title" id="title" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="content" class="block text-gray-700">Содержимое</label>
            <textarea name="content" id="content" class="w-full p-2 border rounded resize-none" rows="5" placeholder="Что у вас нового?" required></textarea>
        </div>

        <div class="mb-4">
            <label for="media" class="block text-gray-700">Медиа (изображение или видео)</label>
            <div class="relative w-64 h-64 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors cursor-pointer" id="media-upload">
                <input type="file" name="media" id="media" class="hidden" accept=".jpg,.jpeg,.png,.gif,.mp4,.mov">
                <div class="text-center" id="upload-prompt">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p id="media-name" class="text-gray-500 mt-2">Добавьте фото или видео</p>
                    <button type="button" class="mt-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors" onclick="document.getElementById('media').click()">Загрузить с устройства</button>
                </div>
                <div id="media-preview" class="hidden w-full h-full"></div>
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white p-2 rounded">Опубликовать</button>
    </form>
</div>

<script>
    document.getElementById('media').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const mediaUpload = document.getElementById('media-upload');
            const mediaName = document.getElementById('media-name');
            const uploadPrompt = document.getElementById('upload-prompt');
            const mediaPreview = document.getElementById('media-preview');

            mediaName.textContent = file.name;

            // Если это изображение, отобразить его
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    mediaPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg" alt="Загруженное медиа">`;
                    mediaPreview.classList.remove('hidden');
                    uploadPrompt.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                // Если это видео, отобразить иконку видео
                mediaPreview.innerHTML = `
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                `;
                mediaPreview.classList.remove('hidden');
                uploadPrompt.classList.add('hidden');
            }
        }
    });
</script>
@endsection