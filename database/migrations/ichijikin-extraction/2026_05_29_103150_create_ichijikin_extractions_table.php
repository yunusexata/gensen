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
        Schema::create('ichijikin_extractions', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_ichijikin_extractions', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ichijikin_extractions');
        Schema::dropIfExists('_history_ichijikin_extractions');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('batch_name', 'ichijikin_extractions_batch_name_idx');
        }

        $table->string('batch_name')->nullable();       // KK_andi.jpg
        $table->text('description')->nullable()->default(null);

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
