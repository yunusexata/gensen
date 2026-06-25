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
        Schema::table('resi_generator_details', function (Blueprint $table) {
            $table->string('no')->nullable();
            $table->string('jenis_pencairan')->nullable();
        });
        Schema::table('_history_resi_generator_details', function (Blueprint $table) {
            $table->string('no')->nullable();
            $table->string('jenis_pencairan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resi_generator_details', function (Blueprint $table) {
            $table->dropColumn('no');
            $table->dropColumn('jenis_pencairan');
        });
        Schema::table('_history_resi_generator_details', function (Blueprint $table) {
            $table->dropColumn('no');
            $table->dropColumn('jenis_pencairan');
        });
    }
};
