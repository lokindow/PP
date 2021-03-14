<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE test.transaction ( id INT NOT NULL AUTO_INCREMENT , payer INT NOT NULL , payee INT NOT NULL , value FLOAT NOT NULL , PRIMARY KEY (id), INDEX idx_payer (payer), INDEX idx_payee (payee))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
