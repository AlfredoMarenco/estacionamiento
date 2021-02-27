<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('plate')->nullable();
            $table->dateTime('datetime_start');
            $table->dateTime('datetime_end')->nullable();
            $table->enum('pagado', ['si' => 1, 'no' => 0, 'cancelado' => 2,'fueradecancelacion'=>3])->default(0);
            $table->float('amount')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tickets');
    }
}
