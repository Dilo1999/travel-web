<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 10);
            // A lang file group such as 'site' (key = dotted key), or '*' for config content (key = sha1 of the English).
            $table->string('group', 32);
            $table->string('key', 191);
            // The English this translation was made from; when the English changes, the row is out of date.
            $table->text('source');
            $table->text('text');
            $table->timestamps();

            $table->unique(['locale', 'group', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
