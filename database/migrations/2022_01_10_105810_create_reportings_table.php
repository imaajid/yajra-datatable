<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_zone');
            $table->date('transaction_date');
            $table->string('invoice_no');
            $table->string('total_before_tax');
            $table->string('tax_amount');
            $table->string('final_amount');
            $table->string('cash');
            $table->string('card');
            $table->string('coupon');
            $table->string('tips');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportings');
    }
}
