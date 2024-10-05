<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->enum('type', ['movie', 'tv_show'])->default('movie');
            $table->integer('episode_number')->nullable();  // Hanya diisi jika serial TV
        });
    }

    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('episode_number');
        });
    }
};
