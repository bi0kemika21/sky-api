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
                    if($post->item_id==1){
                        $post->item = "WITH MESS CABLE WIRE";
                    }else if($post->item_id==2){
                        $post->item = "NON MESS CABLE WIRE";
                    }else if($post->item_id==3){
                        $post->item = "F56 CABLE CONNECTOR";
                    }else if($post->item_id==4){
                        $post->item = "F59 CABLE CONNECTOR";
                    }else if($post->item_id==5){
                        $post->item = "F81 CABLE CONNECTOR";
                    }else if($post->item_id==6){
                        $post->item = "2 WAY SPITTER";
                    }else if($post->item_id==7){
                        $post->item = "P HOOK";
                    }else if($post->item_id==8){
                        $post->item = "S CLAMP";
                    }else if($post->item_id==9){
                        $post->item = "CABLE CLIP";
                    }else if($post->item_id==10){
                        $post->item = "GROUND WIRE";
                    }else if($post->item_id==11){
                        $post->item = "GROUND BLOCK";
                    }else if($post->item_id==12){
                        $post->item = "GROUND ROD";
                    }else if($post->item_id==13){
                        $post->item = "GROUND CLAMP";
                    }else if($post->item_id==14){
                        $post->item = "ISOLATOR";
                    }else if($post->item_id==15){
                        $post->item = "HIGH PASS FILTER";
                    }else if($post->item_id==16){
                        $post->item = "F 2 PAL";
                    }else if($post->item_id==17){
                        $post->item = "TUCKER WIRE";
                    }else if($post->item_id==18){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==19){
                        $post->item = "HD";
                    }else if($post->item_id==20){
                        $post->item = "MODEM";
                    }else if($post->item_id==21){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==22){
                        $post->item = "HD BOX";
                    }else if($post->item_id==23){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==24){
                        $post->item = "HD BOX";
                    }
                    if($post->status=="1"){
                        $post->stat = "Pending";
                    }else if($post->status=="2"){
                        $post->stat = "PR Checked";
                    }else if($post->status=="3"){
                        $post->stat = "Warehouse Checked";
                    }else if($post->status=="4"){
                        $post->stat = "Failed to Comply";
                    }
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
                if($transac->item_id==1){
                        $transac->item = "WITH MESS CABLE WIRE";
                    }else if($transac->item_id==2){
                        $transac->item = "NON MESS CABLE WIRE";
                    }else if($transac->item_id==3){
                        $transac->item = "F56 CABLE CONNECTOR";
                    }else if($transac->item_id==4){
                        $transac->item = "F59 CABLE CONNECTOR";
                    }else if($transac->item_id==5){
                        $transac->item = "F81 CABLE CONNECTOR";
                    }else if($transac->item_id==6){
                        $transac->item = "2 WAY SPITTER";
                    }else if($transac->item_id==7){
                        $transac->item = "P HOOK";
                    }else if($transac->item_id==8){
                        $transac->item = "S CLAMP";
                    }else if($transac->item_id==9){
                        $transac->item = "CABLE CLIP";
                    }else if($transac->item_id==10){
                        $transac->item = "GROUND WIRE";
                    }else if($transac->item_id==11){
                        $transac->item = "GROUND BLOCK";
                    }else if($transac->item_id==12){
                        $transac->item = "GROUND ROD";
                    }else if($transac->item_id==13){
                        $transac->item = "GROUND CLAMP";
                    }else if($transac->item_id==14){
                        $transac->item = "ISOLATOR";
                    }else if($transac->item_id==15){
                        $transac->item = "HIGH PASS FILTER";
                    }else if($transac->item_id==16){
                        $transac->item = "F 2 PAL";
                    }else if($transac->item_id==17){
                        $transac->item = "TUCKER WIRE";
                    }else if($transac->item_id==18){
                        $transac->item = "DIGI BOX";
                    }else if($transac->item_id==19){
                        $transac->item = "HD";
                    }else if($transac->item_id==20){
                        $transac->item = "MODEM";
                    }else if($transac->item_id==21){
                        $transac->item = "DIGI BOX";
                    }else if($transac->item_id==22){
                        $transac->item = "HD BOX";
                    }else if($transac->item_id==23){
                        $transac->item = "DIGI BOX";
                    }else if($transac->item_id==24){
                        $transac->item = "HD BOX";
                    }
                
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
          if(Request::header('X-Auth-Token')) {
            $token = Request::header('X-Auth-Token');

            $search = User::where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';

                return Response::json($this->response,$this->http_status);
            }
            $transac = Transaction::find($id);
            $transac->status = Input::get('status');
            $transac->pr_status = Input::get('pr_status');
            $transac->warehouse_status = Input::get('warehouse_status');
            $transac->item_id = Input::get('item_id');
            $transac->quantity = Input::get('quantity');
                if($transac->save()) {
                    $this->http_status = 200;
                    $this->response['status'] = true;
                    $this->response['message'] = 'Transaction Successfully Updated';
                } else {
                    $this->response['status'] = false;
                }

                $this->response['results'] = $transac;
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
		$transac = Transaction::find($id)->delete();
        if( $transac ){            
            $this->http_status = 200;        
            $this->response['status'] = True;
            $this->response['results']['message'] = "Successfully deleted Transaction"; 
        }else{
            $this->response['error']['record'][] = "Record not found";
        }        
    return Response::json($this->response,$this->http_status);

	}

    public function getpr(){

        if(Request::header('X-Auth-Token')) {
            $token = Request::header('X-Auth-Token');

            $search = User::where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';
                return Response::json($this->response,$this->http_status);
            }
            $posts = DB::table('transactions')->where('pr_encoder','=',$search->first_name)->get();
            if(!empty($posts)){
                foreach ($posts as $post) {
                    if($post->item_id==1){
                        $post->item = "WITH MESS CABLE WIRE";
                    }else if($post->item_id==2){
                        $post->item = "NON MESS CABLE WIRE";
                    }else if($post->item_id==3){
                        $post->item = "F56 CABLE CONNECTOR";
                    }else if($post->item_id==4){
                        $post->item = "F59 CABLE CONNECTOR";
                    }else if($post->item_id==5){
                        $post->item = "F81 CABLE CONNECTOR";
                    }else if($post->item_id==6){
                        $post->item = "2 WAY SPITTER";
                    }else if($post->item_id==7){
                        $post->item = "P HOOK";
                    }else if($post->item_id==8){
                        $post->item = "S CLAMP";
                    }else if($post->item_id==9){
                        $post->item = "CABLE CLIP";
                    }else if($post->item_id==10){
                        $post->item = "GROUND WIRE";
                    }else if($post->item_id==11){
                        $post->item = "GROUND BLOCK";
                    }else if($post->item_id==12){
                        $post->item = "GROUND ROD";
                    }else if($post->item_id==13){
                        $post->item = "GROUND CLAMP";
                    }else if($post->item_id==14){
                        $post->item = "ISOLATOR";
                    }else if($post->item_id==15){
                        $post->item = "HIGH PASS FILTER";
                    }else if($post->item_id==16){
                        $post->item = "F 2 PAL";
                    }else if($post->item_id==17){
                        $post->item = "TUCKER WIRE";
                    }else if($post->item_id==18){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==19){
                        $post->item = "HD";
                    }else if($post->item_id==20){
                        $post->item = "MODEM";
                    }else if($post->item_id==21){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==22){
                        $post->item = "HD BOX";
                    }else if($post->item_id==23){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==24){
                        $post->item = "HD BOX";
                    }
                    if($post->status=="1"){
                        $post->stat = "Pending";
                    }else if($post->status=="2"){
                        $post->stat = "PR Checked";
                    }else if($post->status=="3"){
                        $post->stat = "Warehouse Checked";
                    }else if($post->status=="4"){
                        $post->stat = "Failed to Comply";
                    }
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
    public function getwh(){

        if(Request::header('X-Auth-Token')) {
            $token = Request::header('X-Auth-Token');

            $search = User::where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';
                return Response::json($this->response,$this->http_status);
            }
            $posts = DB::table('transactions')->where('status','=','2')->get();
            if(!empty($posts)){
                foreach ($posts as $post) {
                    if($post->item_id==1){
                        $post->item = "WITH MESS CABLE WIRE";
                    }else if($post->item_id==2){
                        $post->item = "NON MESS CABLE WIRE";
                    }else if($post->item_id==3){
                        $post->item = "F56 CABLE CONNECTOR";
                    }else if($post->item_id==4){
                        $post->item = "F59 CABLE CONNECTOR";
                    }else if($post->item_id==5){
                        $post->item = "F81 CABLE CONNECTOR";
                    }else if($post->item_id==6){
                        $post->item = "2 WAY SPITTER";
                    }else if($post->item_id==7){
                        $post->item = "P HOOK";
                    }else if($post->item_id==8){
                        $post->item = "S CLAMP";
                    }else if($post->item_id==9){
                        $post->item = "CABLE CLIP";
                    }else if($post->item_id==10){
                        $post->item = "GROUND WIRE";
                    }else if($post->item_id==11){
                        $post->item = "GROUND BLOCK";
                    }else if($post->item_id==12){
                        $post->item = "GROUND ROD";
                    }else if($post->item_id==13){
                        $post->item = "GROUND CLAMP";
                    }else if($post->item_id==14){
                        $post->item = "ISOLATOR";
                    }else if($post->item_id==15){
                        $post->item = "HIGH PASS FILTER";
                    }else if($post->item_id==16){
                        $post->item = "F 2 PAL";
                    }else if($post->item_id==17){
                        $post->item = "TUCKER WIRE";
                    }else if($post->item_id==18){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==19){
                        $post->item = "HD";
                    }else if($post->item_id==20){
                        $post->item = "MODEM";
                    }else if($post->item_id==21){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==22){
                        $post->item = "HD BOX";
                    }else if($post->item_id==23){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==24){
                        $post->item = "HD BOX";
                    }
                     if($post->status=="1"){
                        $post->stat = "Pending";
                    }else if($post->status=="2"){
                        $post->stat = "PR Checked";
                    }else if($post->status=="3"){
                        $post->stat = "Warehouse Checked";
                    }else if($post->status=="4"){
                        $post->stat = "Failed to Comply";
                    }
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
    public function getall(){
        //
        if(Request::header('X-Auth-Token')) {
            $token = Request::header('X-Auth-Token');

            $search = User::where('api_token',$token)->first();

            if(!$search) {
                $this->response['status'] = false;
                $this->response['error']['message'] = 'Invalid Token';
                return Response::json($this->response,$this->http_status);
            }
            $posts = DB::table('transactions')->get();
            if(!empty($posts)){
                foreach ($posts as $post) {
                    if($post->item_id==1){
                        $post->item = "WITH MESS CABLE WIRE";
                    }else if($post->item_id==2){
                        $post->item = "NON MESS CABLE WIRE";
                    }else if($post->item_id==3){
                        $post->item = "F56 CABLE CONNECTOR";
                    }else if($post->item_id==4){
                        $post->item = "F59 CABLE CONNECTOR";
                    }else if($post->item_id==5){
                        $post->item = "F81 CABLE CONNECTOR";
                    }else if($post->item_id==6){
                        $post->item = "2 WAY SPITTER";
                    }else if($post->item_id==7){
                        $post->item = "P HOOK";
                    }else if($post->item_id==8){
                        $post->item = "S CLAMP";
                    }else if($post->item_id==9){
                        $post->item = "CABLE CLIP";
                    }else if($post->item_id==10){
                        $post->item = "GROUND WIRE";
                    }else if($post->item_id==11){
                        $post->item = "GROUND BLOCK";
                    }else if($post->item_id==12){
                        $post->item = "GROUND ROD";
                    }else if($post->item_id==13){
                        $post->item = "GROUND CLAMP";
                    }else if($post->item_id==14){
                        $post->item = "ISOLATOR";
                    }else if($post->item_id==15){
                        $post->item = "HIGH PASS FILTER";
                    }else if($post->item_id==16){
                        $post->item = "F 2 PAL";
                    }else if($post->item_id==17){
                        $post->item = "TUCKER WIRE";
                    }else if($post->item_id==18){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==19){
                        $post->item = "HD";
                    }else if($post->item_id==20){
                        $post->item = "MODEM";
                    }else if($post->item_id==21){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==22){
                        $post->item = "HD BOX";
                    }else if($post->item_id==23){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==24){
                        $post->item = "HD BOX";
                    }
                     if($post->status=="1"){
                        $post->stat = "Pending";
                    }else if($post->status=="2"){
                        $post->stat = "PR Checked";
                    }else if($post->status=="3"){
                        $post->stat = "Warehouse Checked";
                    }else if($post->status=="4"){
                        $post->stat = "Failed to Comply";
                    }
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
    public function search() {

    $q = Input::get('que');
    $cat = Input::get('category');
    $searchTerms = explode(' ', $q);
    $query = DB::table('transactions');

    foreach($searchTerms as $term)
    {
        $query->where($cat, 'LIKE', '%'. $term .'%');
    }

    $posts = $query->get();
    if(!empty($posts)){
                foreach ($posts as $post) {
                    if($post->item_id==1){
                        $post->item = "WITH MESS CABLE WIRE";
                    }else if($post->item_id==2){
                        $post->item = "NON MESS CABLE WIRE";
                    }else if($post->item_id==3){
                        $post->item = "F56 CABLE CONNECTOR";
                    }else if($post->item_id==4){
                        $post->item = "F59 CABLE CONNECTOR";
                    }else if($post->item_id==5){
                        $post->item = "F81 CABLE CONNECTOR";
                    }else if($post->item_id==6){
                        $post->item = "2 WAY SPITTER";
                    }else if($post->item_id==7){
                        $post->item = "P HOOK";
                    }else if($post->item_id==8){
                        $post->item = "S CLAMP";
                    }else if($post->item_id==9){
                        $post->item = "CABLE CLIP";
                    }else if($post->item_id==10){
                        $post->item = "GROUND WIRE";
                    }else if($post->item_id==11){
                        $post->item = "GROUND BLOCK";
                    }else if($post->item_id==12){
                        $post->item = "GROUND ROD";
                    }else if($post->item_id==13){
                        $post->item = "GROUND CLAMP";
                    }else if($post->item_id==14){
                        $post->item = "ISOLATOR";
                    }else if($post->item_id==15){
                        $post->item = "HIGH PASS FILTER";
                    }else if($post->item_id==16){
                        $post->item = "F 2 PAL";
                    }else if($post->item_id==17){
                        $post->item = "TUCKER WIRE";
                    }else if($post->item_id==18){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==19){
                        $post->item = "HD";
                    }else if($post->item_id==20){
                        $post->item = "MODEM";
                    }else if($post->item_id==21){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==22){
                        $post->item = "HD BOX";
                    }else if($post->item_id==23){
                        $post->item = "DIGI BOX";
                    }else if($post->item_id==24){
                        $post->item = "HD BOX";
                    }
                     if($post->status=="1"){
                        $post->stat = "Pending";
                    }else if($post->status=="2"){
                        $post->stat = "PR Checked";
                    }else if($post->status=="3"){
                        $post->stat = "Warehouse Checked";
                    }else if($post->status=="4"){
                        $post->stat = "Failed to Comply";
                    }
                    $this->response['results'][] = $post;
            }
            $this->http_status = 200;        
            $this->response['status'] = True;
    }else{
        $this->response['status'] = false;
        $this->response['error']['search'][] = "Query not found";
    }
    return Response::json($this->response,$this->http_status);
    }
}
    