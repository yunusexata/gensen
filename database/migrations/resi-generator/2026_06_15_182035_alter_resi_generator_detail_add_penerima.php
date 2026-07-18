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
            $table->string('nama_penerima')->nullable();
        });
        Schema::table('_history_resi_generator_details', function (Blueprint $table) {
            $table->string('nama_penerima')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resi_generator_details', function (Blueprint $table) {
            $table->dropColumn('nama_penerima');
        });
        Schema::table('_history_resi_generator_details', function (Blueprint $table) {
            $table->dropColumn('nama_penerima');
        });
    }
};
