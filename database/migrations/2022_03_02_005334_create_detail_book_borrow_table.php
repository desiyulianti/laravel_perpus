<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBookBorrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_book_borrow', function (Blueprint $table) {
            $table->bigIncrements('id_detail_book_borrow');
            $table->integer('qty');
            $table->unsignedBigInteger('book_borrow_id');
            $table->unsignedBigInteger('book_id');

            $table->foreign('book_borrow_id')->references('book_borrow_id')->on('book_borrow');
            $table->foreign('book_id')->references('book_id')->on('book');
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
        Schema::dropIfExists('detail_book_borrow');
    }
}
