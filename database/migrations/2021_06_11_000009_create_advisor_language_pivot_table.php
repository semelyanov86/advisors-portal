<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorLanguagePivotTable extends Migration
{
    public function up(): void
    {
        Schema::create('advisor_language', function (Blueprint $table) {
            $table->unsignedBigInteger('advisor_id');
            $table->foreign('advisor_id', 'advisor_id_fk_4141329')->references('id')->on('advisors')->onDelete('cascade');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id', 'language_id_fk_4141329')->references('id')->on('languages')->onDelete('cascade');
        });
    }
}
