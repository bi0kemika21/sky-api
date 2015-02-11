<?php

class ItemsController extends \BaseController {
	protected $items;
    protected $response;
    protected $http_status;
    protected $error;

    public function __construct(Item $item,User $user)
    {
    	$this->user = $user;
        $this->item = $item;
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
		if(Request::header('X-Auth-Token')) {
            $token = Request::header('X-Auth-Token');

            $search = User::where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';
                return Response::json($this->response,$this->http_status);
            }
			$items = DB::table('items')->get();
			if(!empty($items)){
    			foreach ($items as $item) {
    				$this->response['results'][] = $item;
	    			}
    		} else {
    			$this->response['status'] = false;
            	$this->response['error']['message'] = 'No items';	
    		}
    		$this->response['status'] = True;
    	} else {
            $this->http_status = 401;
            $this->response['status'] = false;
            $this->response['error']['message'] = 'Requied Token';
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
		    $item = Item::find($id);
            if (!empty($item)) {
                $this->http_status = 200;
                $this->response['results'] = $item->toArray();
                $this->response['status'] = True;
            } else {
                 $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Item';
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
            $this->item = Item::find($id);

            if (Input::has('password')) {
        	    $pw = Input::get('password');
                if (Hash::check($pw, $this->user->password) ) {
        		   $deduct = Input::get('deduct',0);
        		   $this->item->stock = $this->item->stock - $deduct;
            	   
            	} else {
            	    $this->response['status'] = False;
                    $this->http_status = 403;
                    $this->response['error']['password'][] = "Password incorrect";
                    return Response::json($this->response, $this->http_status);
                }
        	    try {
            	    $this->item->save();
            	    $this->response['results'] = $this->item->toArray();
        	    } catch (PDOException $e) {
            	   $userUpdateError = True;
            	   $this->response['error'] = $e;
        	       }
        	    if (!$userUpdateError) {
            	   $this->response['status'] = True;
            	   $this->http_status = 200;
            	   $this->response['results']['message'] = "Updated stock details";
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


}
