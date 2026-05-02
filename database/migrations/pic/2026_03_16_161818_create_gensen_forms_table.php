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
        Schema::create('gensen_forms', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_gensen_forms', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('gensen_forms');
        Schema::dropIfExists('_history_gensen_forms');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
        }

        $table->string('nama_lengkap');
        $table->date('tanggal_lahir');
        $table->date('tanggal_kepulangan')->nullable();
        $table->string('nama_facebook')->nullable();
        $table->string('nomor_whatsapp')->nullable();
        $table->string('email')->nullable();
        $table->text('alamat_jepang')->nullable();
        $table->string('kode_pos_jepang')->nullable();
        $table->string('nama_lpk')->nullable();

        // REK PENERIMA
        $table->string('no_rekening_penerima')->nullable();
        $table->string('nama_bank_penerima')->nullable();
        $table->string('nama_penerima')->nullable();

        $table->string('status')->nullable();
        $table->integer('tahun_gensen')->nullable();
        $table->integer('tahun_transfer')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
