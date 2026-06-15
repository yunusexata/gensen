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
        Schema::table('ichijikin_extractions', function (Blueprint $table) {
            $table->string('zip_path')->nullable();
            $table->timestamp('zip_generated_at')->nullable();
            $table->string('zip_status')->nullable();
            $table->text('zip_error_message')->nullable(); // kalau gagal
            $table->timestamp('zip_started_at')->nullable();
            $table->timestamp('zip_finished_at')->nullable();
        });
        Schema::table('_history_ichijikin_extractions', function (Blueprint $table) {
            $table->string('zip_path')->nullable();
            $table->timestamp('zip_generated_at')->nullable();
            $table->string('zip_status')->nullable();
            $table->text('zip_error_message')->nullable(); // kalau gagal
            $table->timestamp('zip_started_at')->nullable();
            $table->timestamp('zip_finished_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ichijikin_extractions', function (Blueprint $table) {
            $table->dropColumn('zip_path');
            $table->dropColumn('zip_generated_at');
            $table->dropColumn('zip_status');
            $table->dropColumn('zip_error_message');
            $table->dropColumn('zip_started_at');
            $table->dropColumn('zip_finished_at');
        });
        Schema::table('_history_ichijikin_extractions', function (Blueprint $table) {
            $table->dropColumn('zip_path');
            $table->dropColumn('zip_generated_at');
            $table->dropColumn('zip_status');
            $table->dropColumn('zip_error_message');
            $table->dropColumn('zip_started_at');
            $table->dropColumn('zip_finished_at');
        });
    }
};
