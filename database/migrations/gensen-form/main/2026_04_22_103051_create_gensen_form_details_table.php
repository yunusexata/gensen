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
        Schema::create('gensen_form_details', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_gensen_form_details', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('gensen_form_details');
        Schema::dropIfExists('_history_gensen_form_details');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('gensen_form_id', 'gensen_form_details_gensen_form_id_idx');
        }
        $table->unsignedBigInteger('gensen_form_id');

        $table->integer('tahun_gensen');
        $table->double('nominal_gensen', 20, 2, true)->nullable();
        $table->date('tanggal_cair')->nullable();
        $table->double('nominal_cair', 20, 2, true)->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
