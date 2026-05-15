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
            $table->index('id_customer', 'gensen_forms_id_customer_idx');
            $table->index('remarks_id', 'gensen_forms_remarks_id_idx');
            $table->index('remarks_type', 'gensen_forms_remarks_type_idx');
            $table->index('status', 'gensen_forms_status_idx');
            $table->index('tanggal_lengkap', 'gensen_forms_tanggal_lengkap_idx');
            $table->index('tanggal_verified', 'gensen_forms_tanggal_verified_idx');
            $table->index('no_input_jepang', 'gensen_forms_no_input_jepang_idx');
        }

        // Sistem
        $table->string('id_customer');
        $table->string('status')->nullable();

        // ---------- //
        // Form Input //
        // ---------- //

        // Data Diri
        $table->string('nama_lengkap');
        $table->date('tanggal_lahir');
        $table->string('email');
        $table->date('tanggal_kepulangan')->nullable();
        $table->string('nama_instagram')->nullable();
        $table->string('nama_tiktok')->nullable();
        $table->string('nomor_whatsapp')->nullable();
        $table->string('nomor_whatsapp_darurat')->nullable();
        $table->text('alamat_jepang')->nullable();
        $table->string('kode_pos_jepang')->nullable();
        $table->string('nama_lpk')->nullable();

        // REK PENERIMA
        $table->string('no_rekening_penerima')->nullable();
        $table->string('nama_bank_penerima')->nullable();
        $table->string('nama_penerima')->nullable();
        $table->string('hubungan_penerima')->nullable();

        // Gensen
        // $table->integer('tahun_gensen')->nullable();
        // $table->integer('tahun_transfer')->nullable();

        // Relasi History
        $table->unsignedBigInteger('remarks_id');
        $table->string('remarks_type');
        $table->string('pic_code')->nullable();

        // Validasi
        $table->boolean('is_should_filled')->default(false)->nullable();
        $table->boolean('is_submitted')->default(false)->nullable();

        // ----------- //
        // Flow Bisnis //
        // ----------- //

        // Step 1 - HS
        // $table->double('nominal_gensen', 20, 2, true)->nullable();
        // $table->double('jumlah_kirim_uang', 20, 2, true)->nullable();
        // $table->text('nama_penerima_dan_hubungan')->nullable();
        $table->date('tanggal_lengkap')->default(null)->nullable();

        // Step 2 - HS2
        $table->date('tanggal_verified')->default(null)->nullable();

        // Step 3 - Admin Jepang
        $table->string('no_input_jepang')->nullable();

        // Step 4 - Admin Jepang
        $table->date('tanggal_pengajuan')->nullable(); // Tanggal Pengajuan Ke Kantor Pajak

        // Step 5 - Acc Exata
        // $table->double('nominal_cair', 20, 2, true)->nullable();
        // $table->date('tanggal_cair')->nullable();

        // MONDAI
        $table->text('keterangan')->nullable();
        $table->boolean('is_previously_processed')->default(false)->nullable(); // Gensen pernah diproses sebelumnya oleh pihak lain (belum/sudah)

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
