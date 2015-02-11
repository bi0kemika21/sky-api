<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->command->info('Start seeds!');
		$this->call('ItemTableSeeder');
		$this->command->info('End seeds!');
	}

}
