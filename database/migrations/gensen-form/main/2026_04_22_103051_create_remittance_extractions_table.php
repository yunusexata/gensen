<?php

use App\Enums\Gensen\JobStatus;
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
        Schema::create('remittance_extractions', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_remittance_extractions', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('remittance_extractions');
        Schema::dropIfExists('_history_remittance_extractions');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('ai_job_id', 'remittance_extractions_ai_job_id_idx');
            $table->index('subject_type', 'remittance_extractions_subject_type_idx');
            $table->index('subject_id', 'remittance_extractions_subject_id_idx');
        }
        $table->unsignedBigInteger('ai_job_id');

        $table->morphs('subject');
        $table->double('confidence_score', 5, 2);
        $table->text('confidence_note')->nullable();
        $table->double('total_transfer', 20, 2, true)->nullable();
        $table->double('ai_total_transfer', 20, 2, true)->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
