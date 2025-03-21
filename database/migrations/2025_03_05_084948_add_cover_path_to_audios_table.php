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
    Schema::table('audios', function (Blueprint $table) {
        $table->string('cover_path')->nullable()->after('file_path');
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('audios', function (Blueprint $table) {
        $table->dropColumn('cover_path');
    });
}
};
