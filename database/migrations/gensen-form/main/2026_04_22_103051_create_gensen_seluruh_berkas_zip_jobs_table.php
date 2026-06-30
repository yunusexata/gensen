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
        Schema::create('gensen_seluruh_berkas_zip_jobs', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_gensen_seluruh_berkas_zip_jobs', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('gensen_seluruh_berkas_zip_jobs');
        Schema::dropIfExists('_history_gensen_seluruh_berkas_zip_jobs');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('gensen_export_import_history_id', 'gensen_sbzj_gensen_ei_history_id_idx');
        }
        $table->unsignedBigInteger('gensen_export_import_history_id'); // pending, processing, success, failed
        $table->string('status'); // pending, processing, success, failed
        $table->text('error_message')->nullable(); // kalau gagal
        $table->string('zip_disk')->nullable();
        $table->string('zip_path')->nullable();
        $table->timestamp('started_at')->nullable();
        $table->timestamp('finished_at')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
