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
        Schema::create('remittance_extraction_groups', function (Blueprint $table) {
            $this->scheme($table, false);
        });

        Schema::create('_history_remittance_extraction_groups', function (Blueprint $table) {
            $this->scheme($table, true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('remittance_extraction_groups');
        Schema::dropIfExists('_history_remittance_extraction_groups');
    }

    private function scheme(Blueprint $table, $is_history = false)
    {

        $table->id();

        if ($is_history) {
            $table->bigInteger('obj_id')->unsigned();
        } else {
            $table->index('remittance_extraction_id', 'remittance_extraction_groups_remittance_extraction_id_idx');
        }
        $table->unsignedBigInteger('remittance_extraction_id');
        $table->string('receiver_name');
        $table->string('receiver_relationship')->nullable();
        $table->integer('transaction_year');

        // We use decimal(15,2) for financial accuracy rather than float/number
        $table->decimal('total_amount', 20, 2);
        $table->string('currency')->default('JPY');
        $table->integer('transfer_transaction_count');

        // THE AUDIT TRAIL: Store the individual amounts as a JSON array
        $table->json('amount_details');
        $table->boolean('is_validate')->default(false);

        $table->bigInteger("created_by")->unsigned()->nullable();
        $table->bigInteger("updated_by")->unsigned()->nullable();
        $table->bigInteger("deleted_by")->unsigned()->nullable()->default(null);
        $table->softDeletes();
        $table->timestamps();
    }
};
