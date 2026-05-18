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
        Schema::table('send_email_logs', function (Blueprint $table) {
            $table->json('data')
                ->nullable()
                ->after('subject_type');
        });
        Schema::table('_history_send_email_logs', function (Blueprint $table) {
            $table->json('data')
                ->nullable()
                ->after('subject_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('send_email_logs', function (Blueprint $table) {
            $table->dropColumn('data');
        });
        Schema::table('_history_send_email_logs', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
};
