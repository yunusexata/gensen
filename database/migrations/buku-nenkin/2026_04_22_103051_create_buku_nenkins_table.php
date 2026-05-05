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
        Schema::create('buku_nenkins', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_buku_nenkins', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku_nenkins');
        Schema::dropIfExists('_history_buku_nenkins');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('nama', 'buku_nenkins_nama_idx');
            $table->index('tanggal_lahir', 'buku_nenkins_tanggal_lahir_idx');
        }

        $table->string('nama')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->text('alamat_jepang')->nullable();
        $table->date('tanggal_kepulangan')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
