<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static $rules = array(
        'login'=>array(
            'email'=>'required|email',
            'password'=>'required',
        ),
        'store'=> array(
            'first_name'=>'required|min:2|max:35',
            'last_name'=>'required|min:2|max:35',
            'contact_number' => 'required|min:11|max:11',
            'email' => 'required|max:35', 
            'password'=>'required|between:6,20',
            'birthday'=>'required|date',
   			'position' => 'required'  
        ),
        'update' => array(
        	'old_password' =>'required'
        	)
       ); 
}
