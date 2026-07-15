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
        Schema::table('gensen_forms', function (Blueprint $table) {

            $table->date('tanggal_cancel')->default(null)->nullable();
            $table->date('tanggal_honnin')->default(null)->nullable();
            $table->date('tanggal_mondai')->default(null)->nullable();
        });
        Schema::table('_history_gensen_forms', function (Blueprint $table) {
            $table->date('tanggal_cancel')->default(null)->nullable();
            $table->date('tanggal_honnin')->default(null)->nullable();
            $table->date('tanggal_mondai')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gensen_forms', function (Blueprint $table) {
            $table->dropColumn('tanggal_cancel');
            $table->dropColumn('tanggal_honnin');
            $table->dropColumn('tanggal_mondai');
        });
        Schema::table('_history_gensen_forms', function (Blueprint $table) {
            $table->dropColumn('tanggal_cancel');
            $table->dropColumn('tanggal_honnin');
            $table->dropColumn('tanggal_mondai');
        });
    }
};
