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
        Schema::table('remittance_extraction_groups', function (Blueprint $table) {
            $table->string('receiver_relationship')->default(null)->nullable();
        });
        Schema::table('_history_remittance_extraction_groups', function (Blueprint $table) {
            $table->string('receiver_relationship')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remittance_extraction_groups', function (Blueprint $table) {
            $table->dropColumn('receiver_relationship');
        });
        Schema::table('_history_remittance_extraction_groups', function (Blueprint $table) {
            $table->dropColumn('receiver_relationship');
        });
    }
};
