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
        Schema::create('seluruh_berkas_jobs', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_seluruh_berkas_jobs', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seluruh_berkas_jobs');
        Schema::dropIfExists('_history_seluruh_berkas_jobs');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('gensen_form_id', 'seluruh_berkas_jobs_gensen_form_id_idx');
        }
        $table->foreignId('gensen_form_id')->constrained();

        $table->text('error_message')->nullable();

        $table->timestamp('started_at')->nullable();
        $table->timestamp('finished_at')->nullable();

        // lifecycle state
        $table->string('status');

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
