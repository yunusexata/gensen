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
        Schema::create('ichijikin_extraction_details', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_ichijikin_extraction_details', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ichijikin_extraction_details');
        Schema::dropIfExists('_history_ichijikin_extraction_details');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('stored_name', 'ichijikin_ed_stored_name_idx');
            $table->index('ichijikin_extraction_id', 'ichijikin_ed_ichijikin_extraction_id_idx');
        }

        $table->unsignedBigInteger('ichijikin_extraction_id');
        $table->text('stored_name')->nullable();         // uuid filenamex
        $table->string('disk')->nullable();                // local / s3
        $table->text('path')->nullable();                // storage path
        $table->text('note')->nullable();                // Attachment Note

        $table->string('extension')->nullable();           // jpg
        $table->string('mime_type')->nullable();           // image/jpeg
        $table->string('file_size')->nullable();           // bytes

        $table->text('checksum')->nullable();            // sha256 hash (anti duplicate)

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
