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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('mt_role_id')->unsigned();
        $table->bigInteger('mt_departements_id')->unsigned();
        $table->bigInteger('mt_positions_id')->unsigned();
        $table->string('mt_username');
        $table->string('mt_useremail');
        $table->string('mt_userpass');
        $table->timestamps();

        // Menambahkan foreign key
        // $table->foreign('mt_role_id')->references('id')->on('roles')->onDelete('set null');
        // $table->foreign('mt_departements_id')->references('id')->on('departements')->onDelete('set null');
        // $table->foreign('mt_positions_id')->references('id')->on('positions')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
