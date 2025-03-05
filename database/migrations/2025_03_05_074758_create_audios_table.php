<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audios', function (Blueprint $table) {
            $table->id();
            $table->string('title');            // Название аудиозаписи
            $table->string('artist')->nullable(); // Исполнитель (может быть NULL)
            $table->string('file_path');        // Путь к файлу аудиозаписи
            $table->integer('duration')->nullable(); // Длительность в секундах (может быть NULL)
            $table->text('description')->nullable(); // Описание (может быть NULL)
            $table->timestamps();                // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audios');
    }
};
