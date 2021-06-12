<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryFileTable extends Migration
{
    public function up(): void
    {
        Schema::create('temporary_files', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('folder');
            $table->string('filename');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temporary_files');
    }
}
