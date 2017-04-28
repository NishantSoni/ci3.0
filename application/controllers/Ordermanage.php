<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Ordermanage extends REST_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('UTC');
		$this->load->model('common_model');
	}

	//function to create user or register user
	function createUser_post(){
		//catch the values from request
		$useremail 	= 	$this->post('useremail');
		$username 	= 	$this->post('username');

		//if email or name key is blank then show the message
		if( $useremail == '' || $username == '' ){
			$this->response(array('error'=>1 , 'message'=>'Fields should not be blank..!!' , 'data'=>array()  ));
		}

		if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
      $this->response(array('error'=>1 , 'message'=>'Email is not valid....!!' , 'data'=>array()  ));
    }

		//Check email is exist or not
		$userData = $this->common_model->find_data('row',array('useremail'=>$useremail),'users',0,0,'userid','DESC');
		if( !empty($userData) ){
			$this->response(array('error'=>1 , 'message'=>'Email id is already registered..!!' , 'data'=>array()  ));
		}

		//prepare array for inserting it to the DB
		$insertUserData = array('useremail' => $useremail , 'username' => $username) ;

		//create user
		$createdUserId = $this->common_model->save_data($insertUserData,0,'','users');

		if($createdUserId > 0)
		{
			//user is created, then show the success message
			$this->response(array('error'=>0 , 'message'=>'User is created successfully..!!' , 'data'=>array('createduserid' => $createdUserId )  ));
		}else{
			$this->response(array('error'=>1 , 'message'=>'User is not created..!!' , 'data'=>array()  ));
		}
	}

	//function for creating order of the user
	function createOrder_post(){
		//catch the values from request
		$userid 		= 	$this->post('userid');
		$itemInfo 	= 	$this->post('item_info');

		// if any field should be blank then it should throw an error.
		if($userid == '' || $itemInfo == ''){
			$this->response(array('error'=>1 , 'message'=>'Fields should not be blank..!!' , 'data'=>array()  ));
		}

		//Check email is exist or not
		$userData = $this->common_model->find_data('row',array('userid'=>$userid),'users',0,0,'userid','DESC');
		if( empty($userData) ){
			$this->response(array('error'=>1 , 'message'=>'User id not found, please create the user after that order..!!' , 'data'=>array()  ));
		}

		//now create an order via email id
		$insertedData = array( 'userid' => $userid );

		$createdOrderId = $this->common_model->save_data($insertedData,0,'','userorders');

		if($createdOrderId > 0)
		{
			//order is created successfully, now let's insert record in the order items table for this order id..
			//first we will decode the json..
			$orderInfo 	=  json_decode($itemInfo);

			//check it , it is object or array..
			if (is_object($orderInfo)) {
					$orderArr = get_object_vars($orderInfo);
			}

			if (is_array($orderInfo)) {
					$orderArr = array_map(__FUNCTION__, $orderInfo);
			}

			// catch the values from 'orderData' key from the request..
			$orderData = $orderArr['orderData'];

			// there is a loop, from which all the items will be inserted in the database..
			$i=0;
			while( $i<sizeof($orderData) )
			{
				// check all the correct key name is present or not..
				if( isset($orderData[$i]->itemname) && isset($orderData[$i]->itemprice) && isset($orderData[$i]->itemquantity) ){
					//prepare array to insert in the order item table.
					$orderDataInsert = array(
																		'userorderid' 	=> $createdOrderId,
																		'itemname' 			=> $orderData[$i]->itemname,
																		'itemprice'			=> $orderData[$i]->itemprice,
																		'itemquantity'	=> $orderData[$i]->itemquantity
														 		);
					$createdItemId = $this->common_model->save_data($orderDataInsert,0,'','orderitems');

					if($createdItemId <= 0){
						$this->response(array('error'=>1 , 'message'=>'Item is not inserted successfully..!!' , 'data'=>array()  ));
					}
				}else{
					$this->response(array('error'=>1 , 'message'=>'Order is created, but items fields are not valid..!!' , 'data'=>array('orderid' => $createdOrderId)  ));
				}
				$i++;
			}

			//finally order is created, give the success message..
			$this->response(array('error'=>0 , 'message'=>'Order is created successfully..!!' , 'data'=>array('createdorderid' => $createdOrderId)  ));

		}else{
			$this->response( array('error'=>1 , 'message'=>'Order is not created..!!' , 'data'=>array()  ));
		}
	}

	//function for fetching orders on the basis of search
	function getOrder_post(){
		$userid 		= 	$this->post('userid');
		$orderid 		= 	$this->post('orderid');

		if( $userid == '' &&  $orderid == ''){
			$this->response( array('error'=>1 , 'message'=>'user id or order id is required to search..!!' , 'data'=>array()  ));
		}

		if($userid != '' && $orderid != ''){
			$this->response( array('error'=>1 , 'message'=>'Please select only 1 value to search..!!' , 'data'=>array()  ));
		}

		//find the order data
		$orderData = array();
		if($userid != '' ){
			$orderData = $this->common_model->find_data('array',array('userid'=>$userid),'userorders',0,0,'userorderid','DESC');
			foreach( $orderData as $key => $val  ){
				$orderData[$key]['order_items'] = $this->common_model->find_data('array',array('userorderid'=>$val['userorderid']),'orderitems',0,0,'orderitemid','DESC');
			}
		}else{
			$orderData = $this->common_model->find_data('row',array('userorderid'=>$orderid),'userorders',0,0,'userorderid','DESC');
			if(isset($orderData['userorderid'])){
				$orderData['order_items'] = $this->common_model->find_data('array',array('userorderid'=>$orderData['userorderid']),'orderitems',0,0,'orderitemid','DESC');
			}
		}
		$this->response( array('error'=>0 , 'message'=>'Success' , 'data'=>$orderData  ));

	}


	//function for getting todays records
	function getTodaysOrder_post(){
		// we will fetch the data according to todays date.
		$orderData 			= 	$this->common_model->find_data('array',array('DATE(updatedat)'=>date('Y-m-d')),'userorders',0,0,'userorderid','DESC');
		if(!empty($orderData)){
			foreach( $orderData as $key => $val ){
				$orderData[$key]['order_items'] = $this->common_model->find_data('array',array('userorderid'=>$val['userorderid']),'orderitems',0,0,'orderitemid','DESC');
			}
			$this->response( array('error'=>0 , 'message'=>'Success' , 'data'=>$orderData  ));
		}else{
			$this->response( array('error'=>0 , 'message'=>'Success' , 'data'=>$orderData  ));
		}

	}

	// function for updating order.
	function updateOrder_post(){
		$orderId 			= $this->post('order_id');
		$isCancel 		= $this->post('is_cancel');
		$isPayment 		=	$this->post('is_payment');
		$orderItems 	= $this->post('item_info');

		if($orderId <= 0 || $orderId == ''  ){
			$this->response( array('error'=>1 , 'message'=>'Please check the values.' , 'data'=>array()  ));
		}

		// we will update one field at a time according to the requiremnts..
		if($isCancel == 1 && $isPayment == 1){
			$this->response( array('error'=>1 , 'message'=>'You can not update more than one field at a time.' , 'data'=>array()  ));
		}

		if($isCancel == 1 && $orderItems != ''){
			$this->response( array('error'=>1 , 'message'=>'You can not update more than one field at a time.' , 'data'=>array()  ));
		}

		if($isPayment == 1 && $orderItems != ''){
			$this->response( array('error'=>1 , 'message'=>'You can not update more than one field at a time.' , 'data'=>array()  ));
		}

		if( ($isCancel == 1) && ( $isPayment == 1 ) &&  ( $orderItems != '' ) ){
			$this->response( array('error'=>1 , 'message'=>'You can not update more than one field at a time.' , 'data'=>array()  ));
		}

		//check order id is eixist or not
		$orderData 			= 	$this->common_model->find_data('row',array('userorderid'=> $orderId),'userorders',0,0,'userorderid','DESC');
		if(empty($orderData)){
			$this->response( array('error'=>1 , 'message'=>'Order is not found' , 'data'=>array()  ));
		}

		// update order cancel
		if($isCancel == 1){
			$updateData = array('status' => 'cancelled');
			$updateUser=$this->common_model->save_data($updateData,$orderId,'userorderid','userorders');
			$this->response( array('error'=>0 , 'message'=>'Order is cancelled.' , 'data'=>array('orderid' => $orderId)  ));
		}

		// update payment received
		if($isPayment == 1){
			$updateData = array('ispaymentreceived' => 1);
			$updateUser=$this->common_model->save_data($updateData,$orderId,'userorderid','userorders');
			$this->response( array('error'=>0 , 'message'=>'Order payment is received.' , 'data'=>array('orderid' => $orderId)  ));
		}

		// update order items
		if($orderItems != ''){
			//first we will decode the json..
			$orderInfo 	=  json_decode($orderItems);

			//check it , it is object or array..
			if (is_object($orderInfo)) {
					$orderArr = get_object_vars($orderInfo);
			}
			if (is_array($orderInfo)) {
					$orderArr = array_map(__FUNCTION__, $orderInfo);
			}

			// catch the values from 'orderData' key from the request..
			$orderData = $orderArr['orderData'];

			// there is a loop, from which all the items will be inserted in the database..
			$i=0;
			while( $i<sizeof($orderData) )
			{
				// check all the correct key name is present or not..
				if( isset($orderData[$i]->itemname) && isset($orderData[$i]->itemprice) && isset($orderData[$i]->itemquantity) ){
					//prepare array to insert in the order item table.
					$orderDataInsert = array(
																		'userorderid' 	=> $orderId,
																		'itemname' 			=> $orderData[$i]->itemname,
																		'itemprice'			=> $orderData[$i]->itemprice,
																		'itemquantity'	=> $orderData[$i]->itemquantity
																);
					$createdItemId = $this->common_model->save_data($orderDataInsert,0,'','orderitems');

					if($createdItemId <= 0){
						$this->response(array('error'=>1 , 'message'=>'Item is not updated successfully..!!' , 'data'=>array()  ));
					}
				}else{
					$this->response(array('error'=>1 , 'message'=>'Items fields are not valid..!!' , 'data'=>array('orderid' => $createdOrderId)  ));
				}
				$i++;
			}

			$this->response(array('error'=>0 , 'message'=>'Item is  updated successfully..!!' , 'data'=>array('orderid' => $orderId)  ));
		}
	}


}
