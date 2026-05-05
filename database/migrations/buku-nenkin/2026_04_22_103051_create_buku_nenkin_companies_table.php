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
        Schema::create('buku_nenkin_companies', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_buku_nenkin_companies', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku_nenkin_companies');
        Schema::dropIfExists('_history_buku_nenkin_companies');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('buku_nenkin_id', 'buku_nenkin_companies_buku_nenkin_id_idx');
        }

        $table->unsignedBigInteger('buku_nenkin_id');
        $table->text('nama_perusahaan')->nullable();
        $table->text('alamat_perusahaan')->nullable();
        $table->string('no_telp')->nullable();
        $table->date('tanggal_kerja_awal')->nullable();
        $table->date('tanggal_kerja_akhir')->nullable();
        $table->string('jenis_nenkin')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
