<?php

use App\Models\GensenForm\GensenFormLink;
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
        Schema::create('gensen_form_links', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_gensen_form_links', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('gensen_form_links');
        Schema::dropIfExists('_history_gensen_form_links');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {
        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();

            // unique access token (used in URL)
            $table->uuid('token');
        } else {
            $table->index('token', 'gensen_form_links_token_idx');
            $table->index('pic_code', 'gensen_form_links_pic_code_idx');
            $table->index('created_by', 'gensen_form_links_created_by_idx');
            $table->index('expired_at', 'gensen_form_links_expired_at_idx');
            $table->index('status', 'gensen_form_links_status_idx');

            // unique access token (used in URL)
            $table->uuid('token')->unique();
        }

        // PIC / marketing / agent reference
        $table->string('pic_code')->nullable();

        // optional password protection
        $table->string('password')->nullable();

        // usage control
        $table->string('name')->nullable();
        $table->unsignedInteger('max_usage')->default(1);
        $table->unsignedInteger('used_count')->default(0);

        // expiration
        $table->timestamp('expired_at')->nullable();

        // lifecycle state
        $table->enum('status', [
            GensenFormLink::STATUS_ACTIVE,
            GensenFormLink::STATUS_INACTIVE,
            GensenFormLink::STATUS_EXPIRED,
            GensenFormLink::STATUS_CLOSED,
        ])->default(GensenFormLink::STATUS_ACTIVE);

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
