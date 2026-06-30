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
        Schema::table('gensen_export_import_histories', function (Blueprint $table) {
            $table->json('customer_ids')
                ->nullable()
                ->after('file_path');
        });
        Schema::table('_history_gensen_export_import_histories', function (Blueprint $table) {
            $table->json('customer_ids')
                ->nullable()
                ->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gensen_export_import_histories', function (Blueprint $table) {
            $table->dropColumn('customer_ids');
        });
        Schema::table('_history_gensen_export_import_histories', function (Blueprint $table) {
            $table->dropColumn('customer_ids');
        });
    }
};
