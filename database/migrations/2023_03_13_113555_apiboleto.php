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
        Schema::create('api_boletos', function (Blueprint $table) {
            $table->id();
            $table->float('valor', 8, 2);
            $table->float('multa', 8, 2);
            $table->float('juros', 8, 2);
            $table->float('valor_final', 8, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_boletos');
    }
};
