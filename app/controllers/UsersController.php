<?php

class UsersController extends \BaseController {
	protected $user;
    protected $response;
    protected $http_status;
    protected $error;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->response = array( 'status'=>False, 'results'=>array(),'error'=>array());
        $this->http_status = 400;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$users = array();
        $users = User::all();
        if (isset($users) && $users->count()) {
          $this->response['status'] = True;
          $this->response['results'] = $users->toArray();
          $this->http_status = 200;
        } else {
          $this->response['error']['users'][] = "No users"; 
        }
        return Response::json($this->response,$this->http_status);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validator = Validator::make(Input::all(), $rules = User::$rules['store']);
        if ($validator->passes()) {
            $token =  hash('sha256',Str::random(10),false);
            $this->user->first_name = Input::get('first_name','firstname');
            $this->user->last_name = Input::get('last_name','lastname');
            $this->user->contact_number = Input::get('contact_number','contact_number');
            $this->user->email = Input::get('email','email@example.com');
            $this->user->birthday = date("d-m-Y", strtotime(Input::get('birthday',date("d-m-Y"))) );
            $this->user->password = Hash::make(Input::get('password','password'));
            $this->user->api_token = $token;
            $this->user->position = Input::get('position');
            $userInsertError = False;
            try {
                $this->user->save();
                $this->response['results'] = $this->user->toArray();
                $this->response['message'] = 'Successfully created User';
                $this->http_status = 200;
                $this->response['status'] = True;
            } catch (PDOException $e) {
                $this->response['error'] = $e;
            }
        } else {
            $this->response['error']= $validator->messages()->toArray();
        }
        return Response::json($this->response,$this->http_status);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		if(Request::header('X-Auth-Token')) {
            $token = Request::header('X-Auth-Token');

            $search = $this->user->where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';

                return Response::json($this->response,$this->http_status);
            }
		    $user = User::find($id);
            if (!empty($user)) {
                $this->http_status = 200;
                $this->response['results'] = $user->toArray();
                $this->response['status'] = True;
            } else {
                 $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid User';
            }
        } else {
            $this->http_status = 401;
            $this->response['status'] = false;
            $this->response['error']['message'] = 'Required Token';

            return Response::json($this->response,$this->http_status);

        }
        return Response::json($this->response,$this->http_status);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		if(Request::header('X-Auth-Token')) {
            $token = Request::header('X-Auth-Token');

            $search = $this->user->where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';

                return Response::json($this->response,$this->http_status);
            }
		    $userUpdateError = False;
            $data = Input::all();
            $this->user = User::find($id);

            if (Input::has('password')) {
        	    $pw = Input::get('password');
                if (Hash::check($pw, $this->user->password) ) {
        		   $this->user->first_name = Input::get('first_name',$this->user->firstname);
            	   $this->user->last_name = Input::get('last_name',$this->user->lastname);
            	   $this->user->contact_number = Input::get('contact_number',$this->user->contact_number);
            	   $this->user->email = Input::get('email',$this->user->email);
            	   $this->user->birthday = date("d-m-Y", strtotime(Input::get('birthday',$this->user->birthday)));
            	   $this->user->position = Input::get('position',$this->user->position);
                }else{
            	    $this->response['status'] = False;
                    $this->http_status = 403;
                    $this->response['error']['password'][] = "Password incorrect";
                    return Response::json($this->response, $this->http_status);
                }
        	    try {
            	    $this->user->save();
            	    $this->response['results'] = $this->user->toArray();
        	    } catch (PDOException $e) {
            	   $userUpdateError = True;
            	   $this->response['error'] = $e;
        	       }
        	    if (!$userUpdateError) {
            	   $this->response['status'] = True;
            	   $this->http_status = 200;
            	   $this->response['results']['message'] = "Updated user details";
        	    }    
            } else {
        	    $this->response['status'] = False;
                $this->http_status = 403;
                $this->response['error']['password'][] = "Enter password ";
            }
        } else {
            $this->http_status = 401;
            $this->response['status'] = false;
            $this->response['error']['message'] = 'Required Token';

        return Response::json($this->response,$this->http_status);
		}
        return Response::json($this->response,$this->http_status);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function login(){
		$validator = Validator::make(Input::all(), $rules = User::$rules['login']);
        if ($validator->passes()) {
        	$credentials = [
  			 	'email' => Input::get('email'),
   				'password' => Input::get('password')
			];
           if ( Auth::attempt($credentials)) {
                $search = $this->user->where('email',Input::get('email'))->first();
                $this->http_status = 200;
                $this->response['results'] = 'Successfully logged in';
                $this->response['api_token'] = $search->api_token;
                $this->response['position'] = $search->position;
                $this->response['status']= True;

            } else {
                $this->http_status = 401;
                $this->response['error']['password'][] ="Invalid email or password.";
            }

        } else {
          $this->response['error'] = $validator->messages()->toArray();
        }
        return Response::json($this->response,$this->http_status);
	}


}
