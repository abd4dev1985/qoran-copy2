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
        Schema::create('tafseers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ayah_id')->nullable();
            $table->longText('all_myasar_text')->nullable();
            $table->longText('jalalayn')->nullable();
            $table->longText('baghawi')->nullable();
            $table->timestamps();
            $table->integer('page_id')->nullable();
            $table->integer('surah_id')->nullable();

        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tafseers');
    }
};
