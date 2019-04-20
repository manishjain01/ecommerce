<?php

namespace App\Http\Controllers\Front;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
use App\Color;
use App\Cart;
use App\Review;
use App\Wishlist;
use App\Country;
use App\Reviews;
use App\Category;
use App\EmailTemplate;
use App\Helpers\EmailHelper;
use App\Helpers\CommonHelpers;
use Intervention\Image\ImageManagerStatic as Image;
Use DB;
use Validator;
use Config;
use Input;
use App\Helpers\BasicFunction;
use Mail;
use Crypt;
use Illuminate\Support\Facades\Auth;
use Session;
use File;
use PaytmWallet;

class OrderController extends Controller
{
    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    /*public function order()
    {
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $order->id,
          'user' => $user->id,
          'mobile_number' => $user->phonenumber,
          'email' => $user->email,
          'amount' => $order->amount,
          'callback_url' => 'http://example.com/payment/status'
        ]);
        return $payment->receive();
    }*/

    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        pr($transaction);exit;
        $response = $transaction->response();
        pr($response);exit;
        //Check out response parameters sent by paytm here -> 'http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm';
        
        if($transaction->isSuccessful()){
          //Transaction Successful
        }else if($transaction->isFailed()){
          //Transaction Failed
        }else if($transaction->isOpen()){
          //Transaction Open/Processing
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id
    }  
    
    /**
    * Obtain the transaction status/information.
    *
    * @return Object
    */
    public function statusCheck(){
        $status = PaytmWallet::with('status');
        $status->prepare(['order' => '4446546546545']);
        $status->check();
        
        $response = $status->response(); // To get raw response as object
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=txn-status-api-description
        
        if($status->isSuccessful()){
          //Transaction Successful
        }else if($status->isFailed()){
          //Transaction Failed
        }else if($status->isOpen()){
          //Transaction Open/Processing
        }
        $status->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $status->getOrderId(); // Get order id
        $status->getTransactionId(); // Get transaction id
    }
    
    /**
    * Initiate refund.
    *
    * @return Object
    */
    public function refund(){
        $refund = PaytmWallet::with('refund');
        $refund->prepare([
            'order' => $order->id,
            'reference' => "refund-order-4", // provide refund reference for your future reference (should be unique for each order)
            'amount' => 300, // refund amount 
            'transaction' => $order->transaction_id // provide paytm transaction id referring to this order 
        ]);
        $refund->initiate();
        $response = $refund->response(); // To get raw response as object
        
        if($refund->isSuccessful()){
          //Refund Successful
        }else if($refund->isFailed()){
          //Refund Failed
        }else if($refund->isOpen()){
          //Refund Open/Processing
        }else if($refund->isPending()){
          //Refund Pending
        }
    }
    
    /**
    * Initiate refund.
    *
    * @return Object
    */
    public function refund1(){
        $refundStatus = PaytmWallet::with('refund_status');
        $refundStatus->prepare([
            'order' => $order->id,
            'reference' => "refund-order-4", // provide reference number (the same which you have entered for initiating refund)
        ]);
        $refundStatus->check();
        
        $response = $refundStatus->response(); // To get raw response as object
        
        if($refundStatus->isSuccessful()){
          //Refund Successful
        }else if($refundStatus->isFailed()){
          //Refund Failed
        }else if($refundStatus->isOpen()){
          //Refund Open/Processing
        }else if($refundStatus->isPending()){
          //Refund Pending
        }
    }
    
     /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function order()
    {
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => '4446546546545',
          'user' => '2',
          'mobile_number' => '9785205042',
          'email' => 'developer.advocosoft@gmail.com',
          'amount' => '5',
          'callback_url' => 'http://mylegalquotes.co.uk/ecommerce/payment/status'
        ]);
        return $payment->view('front.payments.payment')->receive();
    }
}