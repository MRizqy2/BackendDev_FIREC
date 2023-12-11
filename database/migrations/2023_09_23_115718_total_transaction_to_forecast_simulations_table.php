<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TotalTransactionToForecastSimulationsTable extends Migration
{
    public function up()
    {
        Schema::table('forecast_simulations', function (Blueprint $table) {
            $table->bigInteger('total_transaction')->after('name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('forecast_simulations', function (Blueprint $table) {
            $table->dropColumn('total_transaction');
        });
    }
}
