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
        Schema::create('gensen_export_import_histories', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_gensen_export_import_histories', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('gensen_export_import_histories');
        Schema::dropIfExists('_history_gensen_export_import_histories');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('created_by', 'gensen_export_import_histories_created_by_idx');
            $table->index('status', 'gensen_export_import_histories_status_idx');
            $table->index('type', 'gensen_export_import_histories_type_idx');
        }
        $table->string('role')->nullable();
        $table->string('type'); // export or import
        $table->string('job_key'); // Example : Import Data Belum Lengkap, Export Data Lengkap
        $table->string('status'); // pending, processing, success, failed
        $table->string('export_tempalte')->nullable(); // Export Template View

        $table->string('file_name')->nullable(); // nama file
        $table->string('disk')->nullable();                // local / s3
        $table->string('file_path')->nullable(); // path download (kalau export)
        $table->text('error_message')->nullable(); // kalau gagal

        $table->json('filters')->nullable(); // contoh: {date_from, date_to, pic}
        $table->integer('amount')->nullable(); // jumlah data

        $table->timestamp('started_at')->nullable();
        $table->timestamp('finished_at')->nullable();

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
