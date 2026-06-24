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
        Schema::create('resi_generator_details', function (Blueprint $table) {
            $this->scheme($table, false);
        });
        Schema::create('_history_resi_generator_details', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('resi_generator_details');
        Schema::dropIfExists('_history_resi_generator_details');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('resi_generator_id', 'resi_gd_resi_generator_id_idx');
            $table->index('resi_generator_email_id', 'resi_gd_resi_generator_email_id_idx');
        }

        $table->unsignedBigInteger('resi_generator_id');

        $table->string('nama')->nullable();
        $table->integer('nominal')->nullable();
        $table->string('rekening')->nullable();
        $table->string('bank');

        $table->boolean('is_matched')->default(false);
        $table->unsignedBigInteger('resi_generator_email_id')->nullable();
        $table->string('generated_image_disk')->nullable();
        $table->string('generated_image_path')->nullable();
        $table->integer('confidence_score')->nullable();

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
