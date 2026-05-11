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
        Schema::table('gensen_form_details', function (Blueprint $table) {
            $table->double('nominal_gensen', 20, 2, true)->nullable();
        });
        Schema::table('_history_gensen_form_details', function (Blueprint $table) {

            $table->double('nominal_gensen', 20, 2, true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gensen_form_details', function (Blueprint $table) {
            $table->dropColumn('nominal_gensen');
        });
        Schema::table('_history_gensen_form_details', function (Blueprint $table) {
            $table->dropColumn('nominal_gensen');
        });
    }
};
