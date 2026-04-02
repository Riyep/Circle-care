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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mt_user_id');
            $table->string('mt_issue_subject');
            $table->bigInteger('mt_issue_vote');
            $table->string('mt_issue_status');
            $table->string('mt_issu_nomor');
            $table->string('mt_issue_desc');
            $table->string('mt_issue_img');
            $table->string('mt_user_tag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
