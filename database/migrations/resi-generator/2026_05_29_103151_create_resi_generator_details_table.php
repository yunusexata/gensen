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
        }

        $table->unsignedBigInteger('resi_generator_id');
        $table->dateTime('email_received_at')->nullable();
        $table->string('email_subject')->nullable();
        $table->text('email_body_raw')->nullable();
        $table->json('email_parsed')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
