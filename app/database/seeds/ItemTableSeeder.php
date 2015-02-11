<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class ItemTableSeeder extends Seeder {

	public function run()
	{
	DB::table('items')->delete();
         Item::create(array( 'description'=>'WITH MESS CABLE WIRE','stocks'=>'1O','category'=>'CABLE WIRE'));
         Item::create(array( 'description'=>'NON MESS CABLE WIRE','stocks'=>'1O','category'=>'CABLE WIRE'));
         Item::create(array( 'description'=>'F56 CABLE CONNECTOR','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F59 CABLE CONNECTOR','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F81 STRAIGHT CONNECTOR','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'2 WAY SPITTER','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'P HOOK','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'S CLAMP','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'CABLE CLIP','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND WIRE','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND BLOCK','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND ROD','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND CLAMP','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'ISOLATOR','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'HIGH PASS FILTER','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F 2 PAL','stocks'=>'1O','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'TUCKER WIRE','stocks'=>'1O','category'=>'GROUNDING')); 
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'1O','category'=>'SKY'));
         Item::create(array( 'description'=>'HD','stocks'=>'1O','category'=>'SKY'));
         Item::create(array( 'description'=>'MODEM','stocks'=>'1O','category'=>'SKY'));
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'1O','category'=>'DESTINY'));
         Item::create(array( 'description'=>'HD BOX','stocks'=>'1O','category'=>'DESTINY'));
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'1O','category'=>'CAMANAVA'));
         Item::create(array( 'description'=>'HD BOX','stocks'=>'1O','category'=>'CAMANAVA'));	}

}
