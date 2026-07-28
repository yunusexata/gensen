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
        Schema::create('list_postings', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_list_postings', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('list_postings');
        Schema::dropIfExists('_history_list_postings');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('name', 'list_postings_name_idx');
        }

        $table->unsignedBigInteger('template_posting_id');
        $table->string('name');

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
