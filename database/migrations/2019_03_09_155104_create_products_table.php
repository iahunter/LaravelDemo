<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
			
			// Testing out UUIDs
            $table->uuid('id')->primary(); 				// Must add primary() to id if using UUID for foreign key references
			
			$table->string('name');
			$table->text('detail');
			$table->integer('price');
			$table->integer('stock');
			$table->integer('discount');
			$table->unsignedBigInteger('user_id')->unsigned; 	// Use Big Integer for UserID in Laravel 5.8
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
        Schema::dropIfExists('products');
    }
}
