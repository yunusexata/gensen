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
        Schema::create('gensen_form_detail_logs', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_gensen_form_detail_logs', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('gensen_form_detail_logs');
        Schema::dropIfExists('_history_gensen_form_detail_logs');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {

            $table->index('status', 'gensen_form_detail_logs_status_idx');
            $table->index('subject_id', 'gensen_form_detail_logs_subject_id_idx');
            $table->index('subject_type', 'gensen_form_detail_logs_subject_type_idx');
        }
        // polymorphic relation
        $table->morphs('subject');

        // recipient
        $table->string('status');
        $table->string('keterangan');

        // lifecycle
        $table->string('job_status'); // pending | sending | sent | failed

        // monitoring
        $table->unsignedInteger('attempts')->default(0);
        $table->text('error_message')->nullable();

        // timing
        $table->timestamp('started_at')->nullable();
        $table->timestamp('finished_at')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
