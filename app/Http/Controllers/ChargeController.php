<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;

class ChargeController extends Controller
{
    public function charge(Request $request){
        try{
            $stripe = Stripe::charges()->create([
                'amount'=>$request->amount,
                'currency'=>'USD',
                'source' => $request->stripeToken,
                'receipt_email' =>$request->email,
                'description' => "Test payment"
            ]);
            return response()->json($stripe);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function createCustomer(Request $request){
        try{
            $stripe = Stripe::customers()->create([
                'name' => $request->name,
                'source' => $request->stripeToken,
                'email' =>$request->email,
                'description' => "Test customer"
            ]);
            $user = User::find(1);
            $user->customer_id = $stripe['id'];
            $user->update();
            return response()->json($stripe);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function chargeCustomer(Request $request){
        $user= User::find(1);
        try{
            $stripe = Stripe::charges()->create([
                'amount'=>$request->amount,
                'currency' => 'USD',
                'customer' =>$user->customer_id,
            ]);
            $order = new Order();
            $order->order_title = $request->order_title;
            $order->charge_id=$stripe['id'];
            $order->user_id = $user->id;
            $order->save();
            return response()->json($stripe);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function refundCharge(){
        $order = Order::find(2);
        try{
            $stripe = Stripe::refunds()->create($order->charge_id);
            return response()->json($stripe);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

}
