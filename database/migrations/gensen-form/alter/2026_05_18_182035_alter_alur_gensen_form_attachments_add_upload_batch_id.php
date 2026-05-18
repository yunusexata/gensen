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
        Schema::table('gensen_form_attachments', function (Blueprint $table) {
            $table->uuid('upload_batch_id')
                ->nullable()
                ->index()
                ->after('gensen_form_id');
        });
        Schema::table('_history_gensen_form_attachments', function (Blueprint $table) {
            $table->uuid('upload_batch_id')
                ->nullable()
                ->after('gensen_form_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gensen_form_attachments', function (Blueprint $table) {
            $table->dropColumn('upload_batch_id');
        });
        Schema::table('_history_gensen_form_attachments', function (Blueprint $table) {
            $table->dropColumn('upload_batch_id');
        });
    }
};
