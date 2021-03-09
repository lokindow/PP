<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE test.user ( id INT NOT NULL AUTO_INCREMENT , name VARCHAR(100) NOT NULL , email VARCHAR(100) NOT NULL , cpf VARCHAR(30) NULL , cnpj VARCHAR(30) NULL , password VARCHAR(100) NOT NULL , type VARCHAR(50) NOT NULL , PRIMARY KEY (id), INDEX idx_email (email), UNIQUE idx_cpf (cpf), UNIQUE idx_cnpj (cnpj))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
