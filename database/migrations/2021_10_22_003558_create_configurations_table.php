<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_name')->nullable();
            $table->string('store_name')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_symble')->nullable();
            $table->string('tnbc_pk')->nullable();
            $table->float('tnbc_rate', 8, 4)->nullable();
            $table->float('usd_rate', 8, 4)->nullable();
            $table->float('tax_rate', 8, 4)->nullable();
            $table->string('time_zone')->nullable();
            $table->string('protocol')->nullable();
            $table->string('bank')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('store_logo')->nullable();
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
        Schema::dropIfExists('configurations');
    }
}
