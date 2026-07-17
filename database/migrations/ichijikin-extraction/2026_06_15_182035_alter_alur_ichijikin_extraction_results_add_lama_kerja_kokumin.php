<?php

use App\Models\AlurPencairan\AlurPencairanDetail;
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
        Schema::table('ichijikin_extraction_results', function (Blueprint $table) {
            $table->integer('lama_kerja_kokumin')->nullable();
        });
        Schema::table('_history_ichijikin_extraction_results', function (Blueprint $table) {
            $table->integer('lama_kerja_kokumin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ichijikin_extraction_results', function (Blueprint $table) {
            $table->dropColumn('lama_kerja_kokumin');
        });
        Schema::table('_history_ichijikin_extraction_results', function (Blueprint $table) {
            $table->dropColumn('lama_kerja_kokumin');
        });
    }
};
