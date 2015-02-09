<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Transaction extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'transactions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static $rules = array(
        'store'=> array(
            'issued_to'=>'required|min:2|max:50',
            'pr_encoder'=>'required|min:2|max:50',
            'purpose' => 'required|min:10|max:300',
            'item_id' => 'required', 
            'quantity'=>'required|between:1,3',
            'location'=>'required|max:300',
   			'status' => 'required'  
        )
       ); 
}
