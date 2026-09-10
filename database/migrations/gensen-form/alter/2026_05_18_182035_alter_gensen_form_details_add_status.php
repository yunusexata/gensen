<?php

use App\Enums\Gensen\GensenFormDetailStatus;
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
        Schema::table('gensen_form_details', function (Blueprint $table) {
            $table->string('status')->default(null)->nullable();
            $table->text('keterangan')->nullable();
        });
        Schema::table('_history_gensen_form_details', function (Blueprint $table) {
            $table->string('status')->default(null)->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gensen_form_details', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('keterangan');
        });
        Schema::table('_history_gensen_form_details', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('keterangan');
        });
    }
};
