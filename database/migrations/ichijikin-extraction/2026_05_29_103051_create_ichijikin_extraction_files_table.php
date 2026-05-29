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
        Schema::create('ichijikin_extraction_files', function (Blueprint $table) {
            $this->scheme($table, false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ichijikin_extraction_files');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('ichijikin_extraction_id', 'ichijikin_ef_ichijikin_extraction_id_idx');
            $table->index('disk', 'ichijikin_ef_disk_idx');
            $table->index('path', 'ichijikin_ef_path_idx');
            $table->index('merge_disk', 'ichijikin_ef_merge_disk_idx');
            $table->index('merge_path', 'ichijikin_ef_merge_path_idx');
        }

        $table->foreignId('ichijikin_extraction_id')->constrained();
        $table->text('file_stored_name')->nullable();

        $table->string('disk')->nullable();                // local / s3
        $table->text('path')->nullable();                // storage path
        $table->text('note')->nullable();                // Attachment Note

        $table->string('extension')->nullable();           // jpg
        $table->string('mime_type')->nullable();           // image/jpeg
        $table->string('file_size')->nullable();           // bytes

        // MERGE RESULT

        $table->string('merge_disk')->nullable();                // local / s3
        $table->text('merge_path')->nullable();                // storage path
        $table->text('merge_note')->nullable();                // Attachment Note

        $table->string('merge_extension')->nullable();           // jpg
        $table->string('merge_mime_type')->nullable();           // image/jpeg
        $table->string('merge_file_size')->nullable();           // bytes

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
