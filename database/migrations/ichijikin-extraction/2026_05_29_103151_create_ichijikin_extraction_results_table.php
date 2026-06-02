<?php

use App\Models\Ichijikin\IchijikinExtractionResult;
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
        Schema::create('ichijikin_extraction_results', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_ichijikin_extraction_results', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ichijikin_extraction_results');
        Schema::dropIfExists('_history_ichijikin_extraction_results');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('ai_job_id', 'ichijikin_es_ai_job_id_idx');
            $table->index('ichijikin_extraction_file_id', 'ichijikin_es_ichijikin_extraction_file_id_idx');
            $table->index('nama_lengkap', 'ichijikin_es_nama_lengkap_idx');
            $table->index('no_nenkin', 'ichijikin_es_no_nenkin_idx');
            $table->index('type', 'ichijikin_es_type_idx');
            $table->index('status', 'ichijikin_es_status_idx');
        }

        $table->unsignedBigInteger('ai_job_id');
        $table->unsignedBigInteger('ichijikin_extraction_id');
        $table->unsignedBigInteger('ichijikin_extraction_file_id');

        $table->string('nama_lengkap')->nullable();
        $table->string('no_nenkin')->nullable();
        $table->integer('lama_kerja')->nullable();
        $table->double('kokumin', 20, 2, true)->nullable();
        $table->double('nenkin_100', 20, 2, true)->nullable();
        $table->double('nenkin_80', 20, 2, true)->nullable();
        $table->double('nenkin_20', 20, 2, true)->nullable();
        $table->string('type')->default(IchijikinExtractionResult::TYPE_SPEED)->nullable();

        $table->text('error_message')->nullable();

        $table->timestamp('started_at')->nullable();
        $table->timestamp('finished_at')->nullable();
        $table->integer('confidence_score')->nullable();
        $table->text('confidence_note')->nullable();

        // lifecycle state
        $table->string('status');

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
