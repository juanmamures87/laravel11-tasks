<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); Versón más antigua de Laravel para hacer llaves foráneas
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); //Más convención para Laravel a partir del la versión 7, se puede usar como parámetro en constrained el nombre de la tabla a la que se hace referencia para especificar porque, por defecto, se asume que se hace referencia a la tabla users
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
