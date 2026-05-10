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
        Schema::create('ai_jobs', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_ai_jobs', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_jobs');
        Schema::dropIfExists('_history_ai_jobs');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('status', 'ai_jobs_status_idx');
            $table->index('subject_type', 'ai_jobs_subject_type_idx');
            $table->index('subject_id', 'ai_jobs_subject_id_idx');
        }

        $table->morphs('subject');

        $table->string('provider');      // openai
        $table->string('model');         // gpt-4o-mini
        $table->string('job_type');      // classify | extract | validate

        $table->string('status')->default(JobStatus::PENDING);       // pending, processing, success, failed

        $table->json('payload')->nullable();


        $table->integer('input_tokens')->nullable();
        $table->integer('output_tokens')->nullable();
        $table->integer('total_tokens')->nullable();

        $table->decimal('estimated_cost', 12, 6)->nullable();

        $table->timestamp('started_at')->nullable();
        $table->timestamp('finished_at')->nullable();

        $table->text('error_message')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
