<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Notifications\LavieNotification;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;


class AdminController extends Controller
{
    public function view_category(){
        $data= category::all();
        return view('admin.category',compact('data'));
    }
    public function add_category(Request $request){
        $data= new category;
        $data->category_name = $request->category;
        $data->save();
        return redirect()->back()->with('message','Add category successfully');
    }
    public function edit_category($id){
        $category=category::find($id);
        // $data->category_name = $request->
        return view('admin.edit_category',compact('category'));
    }
    public function update_category_confirm(Request $request, $id){

        $category=category::find($id);
        $category->category_name=$request->category_name;
        $category->save();
        return redirect()->back()->with('message','Update Category Name Successfully');
    }
    public function delete_category($id){
        $data=category::find($id);
        $data->delete();
        return redirect()->back()->with('message','Delete Category Successfully');
    }
    public function view_product(){
        $category= category::all();
        // return view('admin.product',compact('data'));
        return view('admin.product',compact('category'));
    }
    public function add_product(Request $request){
        $product= new product;
        $product->title = $request->product_name;
        $product->description = $request->product_description;
        $product->price	 = $request->product_price;
        $product->quantity= $request->product_quantity;
        $product->discount_price= $request->product_discount;
        $product->category= $request->product_categorie;


        $image = $request->product_image;
        $imagename=time().'.'.$image->getClientOriginalExtension();   
        $file = $request->file('product_image');
        $file->move('product', $imagename);
        $product->image=$imagename;

        $product->save();
        return redirect()->back()->with('message','Add product successfully');
    }
    public function show_product(){
        $data= product::all();
        return view('admin.show_product',compact('data'));
    }
    public function delete_product($id){
        $data=product::find($id);
        $data->delete();
        return redirect()->back()->with('message','Deleted Product Successfully');
    }
    public function update_product($id){
        $product=product::with('category')->find($id);
        $category= category::all();
        return view('admin.update_product',compact('product','category'));
    }
    public function update_product_confirm(Request $request, $id){

        $product=product::find($id);
        $product->title = $request->product_name;
        $product->description = $request->product_description;
        $product->price	 = $request->product_price;
        $product->quantity= $request->product_quantity;
        $product->discount_price= $request->product_discount;
        $product->category= $request->product_categorie;


        $image = $request->product_image;
        if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();   
            $file = $request->file('product_image');
            $file->move('product', $imagename);
            $product->image=$imagename;
        }
        $product->save();
        return redirect()->back()->with('message','Update Product Successfully');
    }
    public function order(){
        $order=order::all();
        return view('admin.order',compact('order'));
    }
    public function delivered($id){
        $order=order::find($id);
        $order->delivery_status='Delivered';
        $order->payment_status='Paid';
        $order->save();
        return redirect()->back()->with('message','Updated Delivered Order Successfully');

    }
    public function send_email($id){
        $order=order::find($id);
        return view('admin.email_info',compact('order'));
    }
    public function send_user_email(Request $request, $id){
        $order=order::find($id);
        $details=[
            'greeting'=>$request->greeting,
            'firstline'=>$request->firstline,
            'body'=>$request->body,
            'button'=>$request->email_button,
            'url'=>$request->url_email,
            'lastline'=>$request->lastline
        ];
        Notification::send($order,new LavieNotification($details));
        return redirect()->back();
    }
    public function searchdata(Request $request){
        $searchText=$request->search;
        $order = Order::where('name', 'LIKE', "%$searchText%")
                  ->orWhere('email', 'LIKE', "%$searchText%")
                  ->orWhere('phone', 'LIKE', "%$searchText%")
                  ->orWhere('product_title', 'LIKE', "%$searchText%")
                  ->orWhere('payment_status', 'LIKE', "%$searchText%")
                  ->orWhere('delivery_status', 'LIKE', "%$searchText%")
                  ->get();
        return view('admin.order',compact('order'));
    }
}
