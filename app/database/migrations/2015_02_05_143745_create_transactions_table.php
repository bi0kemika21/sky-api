<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Schema::create('transactions', function(Blueprint $table)
		// {
		// 	//
		// 	$table->increments('id');
  //           $table->integer('user_id')->unsigned()->index()->default(0);
  //           $table->string('issued_to');
  //           $table->string('pr_encoder');
  //           $table->string('purpose');
  //           $table->integer('item_id')->unsigned()->index()->default(0);
  //           $table->string('quantity');
  //           $table->string('location');
  //           $table->string('status');
  //           $table->string('pr_status');
  //           $table->string('warehouse_status');                            
  //           $table->timestamps();
		// });
		Schema::drop('transactions');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transactions');
	}

}
