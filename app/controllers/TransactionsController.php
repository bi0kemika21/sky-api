<?php

class TransactionsController extends \BaseController {
	protected $transactions;
    protected $response;
    protected $http_status;
    protected $error;

    public function __construct(Transaction $transactions)
    {
        $this->transactions = $transactions;
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
			$posts = DB::table('transactions')->where('user_id','=',$search->id)->get();
			if(!empty($posts)){
    			foreach ($posts as $post) {
    				$this->response['results'][] = $post;
    			}
    		} else {
    			$this->response['status'] = false;
            	$this->response['error']['message'] = 'No existing transaction';	
    		}
    		$this->response['status'] = True;
    	} else {
            $this->http_status = 401;
            $this->response['status'] = false;
            $this->response['error']['message'] = 'Required Token';
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
		if(Request::header('X-Auth-Token')) {
            $token = Request::header('X-Auth-Token');

            $search = User::where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';
                return Response::json($this->response,$this->http_status);
            }   
            $validator = Validator::make(Input::all(),Transaction::$rules['store']);

            if( $validator->fails()) {
                $this->response['status'] = false;
                $this->response['error']['message'] = $validator->messages()->toArray();
                return Response::json($this->response,$this->http_status);
            }
            $this->transactions->user_id = $search->id;
            $this->transactions->issued_to = Input::get('issued_to');
            $this->transactions->pr_encoder = Input::get('pr_encoder');
            $this->transactions->purpose = Input::get('purpose');
            $this->transactions->item_id = Input::get('item_id');
            $this->transactions->quantity = Input::get('quantity');
            $this->transactions->location = Input::get('location');
            $this->transactions->status = "1";
            $this->transactions->pr_status = "0";
            $this->transactions->warehouse_status = "0";
            $userInsertError = False;
            try {
                $this->transactions->save();
                $this->response['results'] = $this->transactions->toArray();
                $this->response['message'] = 'Successfully created Transaction';
                $this->http_status = 200;
                $this->response['status'] = True;
            } catch (PDOException $e) {
                $this->response['error'] = $e;
            }
            
        } else {
            $this->http_status = 401;
            $this->response['status'] = false;
            $this->response['error']['message'] = 'Required Token';
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

            $search = User::where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';

                return Response::json($this->response,$this->http_status);
            }
		    $transac = Transaction::find($id);
            if (!empty($transac)) {
                $this->http_status = 200;
                $this->response['results'] = $transac->toArray();
                $this->response['status'] = True;
            } else {
                 $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Transaction';
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
