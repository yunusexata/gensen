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
        Schema::create('ai_usages', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_ai_usages', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_usages');
        Schema::dropIfExists('_history_ai_usages');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('ai_job_id', 'ai_usages_ai_job_id_idx');
        }

        $table->unsignedBigInteger('ai_job_id');

        $table->integer('input_tokens')->default(0);
        $table->integer('output_tokens')->default(0);
        $table->integer('cached_tokens')->default(0);
        $table->integer('thinking_tokens')->default(0);
        $table->integer('total_tokens')->default(0);

        $table->decimal('input_cost', 12, 6)->nullable();
        $table->decimal('output_cost', 12, 6)->nullable();
        $table->decimal('thinking_cost', 12, 6)->nullable();
        $table->decimal('total_cost', 12, 6)->nullable();

        $table->integer('latency_ms')->nullable();

        $table->string('currency')
            ->default('USD');

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
