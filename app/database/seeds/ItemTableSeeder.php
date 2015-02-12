<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class ItemTableSeeder extends Seeder {

	public function run()
	{
	DB::table('items')->delete();
         Item::create(array( 'description'=>'WITH MESS CABLE WIRE','stocks'=>'1O','picture'=>'60% RG6 with messenger cable wire.jpg', 'category'=>'CABLE WIRE'));
         Item::create(array( 'description'=>'NON MESS CABLE WIRE','stocks'=>'1O','picture'=>'60% RG6 non messenger cable wire.jpg','category'=>'CABLE WIRE'));
         Item::create(array( 'description'=>'F56 CABLE CONNECTOR','stocks'=>'1O','picture'=>'F56 CONNECTOR.png','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F59 CABLE CONNECTOR','stocks'=>'1O','picture'=>'','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F81 STRAIGHT CONNECTOR','stocks'=>'1O','picture'=>'F81-STRAIGHT CONNECTOR.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'2 WAY SPITTER','stocks'=>'1O','picture'=>'2-Way splitter.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'P HOOK','stocks'=>'1O','picture'=>'phook.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'S CLAMP','stocks'=>'1O','picture'=>'span clamp.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'CABLE CLIP','stocks'=>'1O','picture'=>'plastick Cable Clip.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND WIRE','stocks'=>'1O','picture'=>'grounding wire.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND BLOCK','stocks'=>'1O','picture'=>'ground block.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND ROD','stocks'=>'1O','picture'=>'ground rod.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND CLAMP','stocks'=>'1O','picture'=>'grounding clamp.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'ISOLATOR','stocks'=>'1O','picture'=>'isolator.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'HIGH PASS FILTER','stocks'=>'1O','picture'=>'high pass filter.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F 2 PAL','stocks'=>'1O','picture'=>'f to pal.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'TUCKER WIRE','stocks'=>'1O','picture'=>'tucker wire.jpg','category'=>'GROUNDING')); 
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'1O','picture'=>'SKY SD BOX.jpg','category'=>'SKY'));
         Item::create(array( 'description'=>'HD','stocks'=>'1O','picture'=>'SKY HD BOX.jpg','category'=>'SKY'));
         Item::create(array( 'description'=>'MODEM','stocks'=>'1O','picture'=>'sky wifi modem.jpg','category'=>'SKY'));
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'1O','picture'=>'','category'=>'DESTINY'));
         Item::create(array( 'description'=>'HD BOX','stocks'=>'1O','picture'=>'','category'=>'DESTINY'));
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'1O','picture'=>'','category'=>'CAMANAVA'));
         Item::create(array( 'description'=>'HD BOX','stocks'=>'1O','picture'=>'','category'=>'CAMANAVA'));	}

}
