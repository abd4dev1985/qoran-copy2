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
        Schema::create('ayahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('surah_id');
            $table->integer('ayah_number');
            $table->text('body')->nullable();
            $table->timestamps();
            $table->integer('page_id');

            $table->unique(['surah_id', 'ayah_number'], 'surah@ayah_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ayahs');
    }
};
