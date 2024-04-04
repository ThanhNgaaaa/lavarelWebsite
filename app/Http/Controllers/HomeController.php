<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use RealRashid\SweetAlert\Facades\Alert;

// use Session;
use Stripe;
use Illuminate\Support\Facades\Session;
class HomeController extends Controller
{
    public function index(){
        $product = Product::paginate(8);
        return view('home.userpage',compact('product'));
    }
    public function redirect(){
        $usertype= Auth::user()->usertype;
        if($usertype=='1'){
            $total_products=Product::all()->count();
            $total_orders=order::all()->count();
            $total_customer=user::all()->count();
            $order=order::all();
            $total_revenue=0;
            foreach($order as $order){
                $total_revenue+=$order->price;
            }
            $total_delivered=order::where('delivery_status','=','Delivered')->get()->count();
            $total_paid=order::where('payment_status','=','Paid')->get()->count();
            return view('admin.home',compact('total_products','total_orders','total_customer','total_revenue','total_delivered','total_paid'));
        }else{
            $product = Product::paginate(9);
            return view('home.userpage',compact('product'));
        }
    }
    public function product_detail($id){
        $product=product::find($id);
        return view('home.product_detail',compact('product'));
    }
    public function add_cart(Request $request, $id){
        if(Auth::id()){
            $user=Auth::user();
            $userid=$user->id;
            $product=product::find($id);
            $product_exist_id=cart::where('product_id','=',$id)->where('user_id','=',$userid)->get('id')->first();

            if($product_exist_id){
                $cart=cart::find($product_exist_id)->first();
                $quantity=$cart->quantity;
                $cart->quantity=$quantity + $request->quantity;
                $cart->save();
                Alert::success('Product Added Successfully');
                return redirect()->back()->with('message','Add To Cart Successfully');
            }else{
                $cart= new cart;
                $cart->name=$user->name;
                $cart->phone=$user->phone;
                $cart->email=$user->email;
                $cart->address=$user->address;
                $cart->user_id=$user->id;
    
                $cart->product_title=$product->title;
                if($product->discount_price>0){
                    $cart->price=$product->discount_price * $request->quantity;
                }else{
                    
                    $cart->price=$product->price * $request->quantity;
                }
                $cart->image=$product->image;
                $cart->product_id=$product->id;
    
                $cart->quantity=$request->quantity;
    
                $cart->save();
                Alert::success('Product Added Successfully');
                return redirect()->back()->with('message','Add To Cart Successfully');
            } 
        }else{
            return redirect('login');
        }
    }
    public function show_cart(){
        $id = Auth::user()->id;
        $cart=cart::where('user_id','=',$id)->get();
        return view('home.show_cart',compact('cart'));
    }
    public function cash_order(){
        $user=Auth::user();
        $userId=$user->id;
        $data=cart::where('user_id','=',$userId)->get();
        foreach($data as $item){
            $order=new order;
            $order->name=$item->name;
            $order->phone=$item->phone;
            $order->email=$item->email;
            $order->address=$item->address;
            $order->user_id=$item->user_id;
            $order->product_title=$item->product_title;
            $order->image=$item->image;
            $order->product_id=$item->product_id;
            $order->quantity=$item->quantity;
            $order->price=$item->price;
            $order->payment_status='cash on delivery';
            $order->delivery_status='processing';
            $order->save();
            $cart_id= $item->id;
            $cart=cart::find($cart_id);
            $cart->delete();

        }
        return redirect()->back()->with('message','We have received your order. We will connect with you soon');    
    }
    public function delete_item_cart($id){
        $data=cart::find($id);
        $data->delete();
        return redirect()->back()->with('message','Deleted Product Successfully');
    }
    public function update_item_cart(Request $request, $id){

        $cart=cart::find($id);
        $product = product::find($cart->product_id);
        $productPrice = ($product->discount_price > 0) ? $product->discount_price : $product->price;
        $cart->quantity= $request->quantity;
        $cart->price=$productPrice * $request->quantity ;

        $cart->save();
        return redirect()->back()->with('message','Updated Cart Successfully');
    }
    public function stripe($totalprice){
        return view('home.stripe',compact('totalprice'));
    }

    public function stripePost(Request $request,$totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thank u for payment." 
        ]);
        $user=Auth::user();
        $userId=$user->id;
        $data=cart::where('user_id','=',$userId)->get();
        foreach($data as $item){
            $order=new order;
            $order->name=$item->name;
            $order->phone=$item->phone;
            $order->email=$item->email;
            $order->address=$item->address;
            $order->user_id=$item->user_id;
            $order->product_title=$item->product_title;
            $order->image=$item->image;
            $order->product_id=$item->product_id;
            $order->quantity=$item->quantity;
            $order->price=$item->price;
            $order->payment_status='Paid';
            $order->delivery_status='processing';
            $order->save();
            $cart_id= $item->id;
            $cart=cart::find($cart_id);
            $cart->delete();

        }
      Session::flash('success','Payment successful!');
              
        return back();
    }
    public function show_order(){
        $user=Auth::user();
        $userid= $user->id;
       
        $order=order::where('user_id','=',$userid)->get();
        return view('home.order',compact('order'));
    }
    public function cancel_order($id){
        $order=order::find($id);
        $order->delivery_status="You've canceled this order";
        $order->save();
        return redirect()->back();
    }
    public function product_search(Request $request){
        $searchText=$request->search;
        $product = product::where('title', 'LIKE', "%$searchText%")
                  ->orWhere('description', 'LIKE', "%$searchText%")
                  ->paginate(6);
        return view('home.all_product',compact('product'));
    }
    public function products(){
        $product = Product::paginate(9);
        return view('home.all_product',compact('product'));
    }

}
