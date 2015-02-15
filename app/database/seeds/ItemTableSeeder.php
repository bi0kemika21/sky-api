<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class ItemTableSeeder extends Seeder {

	public function run()
	{
	DB::table('items')->delete();
         Item::create(array( 'description'=>'WITH MESS CABLE WIRE','stocks'=>'10','picture'=>'60RG6withmessengercablewire.jpg', 'category'=>'CABLE WIRE'));
         Item::create(array( 'description'=>'NON MESS CABLE WIRE','stocks'=>'10','picture'=>'60RG6nonmessengercablewire.jpg','category'=>'CABLE WIRE'));
         Item::create(array( 'description'=>'F56 CABLE CONNECTOR','stocks'=>'10','picture'=>'F56CONNECTOR.png','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F59 CABLE CONNECTOR','stocks'=>'10','picture'=>'','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F81 STRAIGHT CONNECTOR','stocks'=>'10','picture'=>'F81-STRAIGHTCONNECTOR.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'2 WAY SPITTER','stocks'=>'10','picture'=>'2-Waysplitter.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'P HOOK','stocks'=>'10','picture'=>'phook.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'S CLAMP','stocks'=>'10','picture'=>'spanclamp.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'CABLE CLIP','stocks'=>'10','picture'=>'plastickCableClip.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND WIRE','stocks'=>'10','picture'=>'groundingwire.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND BLOCK','stocks'=>'10','picture'=>'groundblock.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND ROD','stocks'=>'10','picture'=>'groundrod.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'GROUND CLAMP','stocks'=>'10','picture'=>'groundingclamp.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'ISOLATOR','stocks'=>'10','picture'=>'isolator.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'HIGH PASS FILTER','stocks'=>'10','picture'=>'highpassfilter.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'F 2 PAL','stocks'=>'10','picture'=>'ftopal.jpg','category'=>'GROUNDING'));
         Item::create(array( 'description'=>'TUCKER WIRE','stocks'=>'10','picture'=>'tuckerwire.jpg','category'=>'GROUNDING')); 
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'10','picture'=>'SKYSDBOX.jpg','category'=>'SKY'));
         Item::create(array( 'description'=>'HD','stocks'=>'10','picture'=>'SKYHDBOX.jpg','category'=>'SKY'));
         Item::create(array( 'description'=>'MODEM','stocks'=>'10','picture'=>'skywifimodem.jpg','category'=>'SKY'));
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'10','picture'=>'','category'=>'DESTINY'));
         Item::create(array( 'description'=>'HD BOX','stocks'=>'10','picture'=>'','category'=>'DESTINY'));
         Item::create(array( 'description'=>'DIGI BOX','stocks'=>'10','picture'=>'','category'=>'CAMANAVA'));
         Item::create(array( 'description'=>'HD BOX','stocks'=>'10','picture'=>'','category'=>'CAMANAVA'));	}

}
