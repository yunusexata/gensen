<?php

use App\Models\AlurPencairan\AlurPencairanDetail;
use App\Models\ListPosting\TemplatePosting;
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
        Schema::table('template_postings', function (Blueprint $table) {
            $table->string('type')->nullable()->default(TemplatePosting::TYPE_LIST_PENCAIRAN);
        });
        Schema::table('_history_template_postings', function (Blueprint $table) {
            $table->string('type')->nullable()->default(TemplatePosting::TYPE_LIST_PENCAIRAN);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_postings', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('_history_template_postings', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
