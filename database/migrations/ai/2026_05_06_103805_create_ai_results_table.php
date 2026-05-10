<?php

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
        Schema::create('ai_results', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_ai_results', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_results');
        Schema::dropIfExists('_history_ai_results');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('ai_job_id', 'ai_results_ai_job_id_idx');
        }

        $table->unsignedBigInteger('ai_job_id');

        $table->string('result_type');
        // gensen_extraction
        // remittance_extraction
        // validation_result

        $table->json('result_json');

        $table->decimal('confidence_score', 5, 2)->nullable();
        $table->text('confidence_note')->nullable();
        $table->boolean('requires_human_review')->default(false);

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
