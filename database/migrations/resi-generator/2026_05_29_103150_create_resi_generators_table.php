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
        Schema::create('resi_generators', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_resi_generators', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('resi_generators');
        Schema::dropIfExists('_history_resi_generators');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('label', 'resi_generators_label_idx');
            $table->index('bank', 'resi_generators_bank_idx');
        }

        $table->string('label');
        $table->string('bank');
        $table->integer('amount')->nullable();

        $table->text('error_message')->nullable();

        $table->timestamp('started_at')->nullable();
        $table->timestamp('finished_at')->nullable();

        // lifecycle state
        $table->string('status');

        $table->string('zip_path')->nullable();
        $table->timestamp('zip_generated_at')->nullable();
        $table->string('zip_status')->nullable();
        $table->text('zip_error_message')->nullable(); // kalau gagal
        $table->timestamp('zip_started_at')->nullable();
        $table->timestamp('zip_finished_at')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
