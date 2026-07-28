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
        Schema::create('template_postings', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_template_postings', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('template_postings');
        Schema::dropIfExists('_history_template_postings');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('name', 'template_postings_name_idx');
            $table->index('path', 'template_postings_path_idx');
            $table->index('disk', 'template_postings_disk_idx');
        }

        $table->string('name');
        $table->string('path');
        $table->string('disk');
        $table->json('text_config')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
