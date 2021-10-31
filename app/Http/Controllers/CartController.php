<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Cart;

class CartController extends Controller
{
    public function store(Request $request){
        Cart::create([
            'user_id' => \Auth::user()->id,
            'product_id'=> $request->post('product_id'),
            'quantity' => $request->post('quantity'),
        ]);
        
        return redirect('/');
    }
    
    public function index(){
        $cart = Cart::select('carts.*','products.name','products.image','products.price')
                ->where('user_id',\Auth::id())
                ->join('products','products.id','=','carts.product_id')
                ->get();
        $subtotal = 0;
        foreach($cart as $carts){
            $subtotal += $carts->price * $carts->quantity;
        }
        return view('cart/index',[
            'total_price' => $subtotal,
            'cart' => $cart,
        ]);
    }
    
    public function checkout(){
        $cart = Cart::select('carts.*','products.name','products.image','products.price')
                ->where('user_id',\Auth::id())
                ->join('products','products.id','=','carts.product_id')
                ->get();
                
        $subtotal = 0;
        
        foreach($cart as $order){
            $subtotal += $order->price * $order->quantity;
        }
        
        
        
        $line_items = [];
        
        
        foreach($cart as $product){
        $line_item = [
                 'name'        => $product->name,
                 'description' => $product->description,
                 'amount'      => $product->price,
                 'currency'    => 'jpy',
                 'quantity'    => $product->quantity,
        ];
             array_push($line_items, $line_item);
        }
        
 
         \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
 
         $session = \Stripe\Checkout\Session::create([
             'payment_method_types' => ['card'],
             'line_items'           => [$line_items],
             'success_url'          => route('product.index'),
             'cancel_url'           => route('login'),
         ]);
        return view('cart.checkout',[
            'session' => $session,
            'publicKey' => env('STRIPE_PUBLIC_KEY')
        ]);
    }
    
    public function destroy(Cart $cart){
        $cart->delete();
        return redirect('/');
    }
}
