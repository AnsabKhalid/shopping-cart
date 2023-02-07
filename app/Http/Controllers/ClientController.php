<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Feedback;
use App\Mail\SendMail;
use App\Cart;
use Session;

class ClientController extends Controller
{
    public function home() {

        $sliders = Slider::All()->where('status', 1);

        $products = Product::where('status', 1)->paginate(8);

        $feedbacks = Feedback::All()->where('status', 1);

        return view('client.home')->with('products', $products)->with('feedbacks', $feedbacks)->with('sliders', $sliders);
    }

    public function shop() {

        $categories = Category::All();

        $products = Product::All()->where('status', 1);

        return view('client.shop')->with('categories', $categories)->with('products', $products);
    }

    static function wishlistTotal() {

        $clientId = Session::get('client')['id'];

        return Wishlist::where('client_id', $clientId)->count();
    }

    public function wishlist(Request $request) {

        if($request->session()->has('client')) {
            $wishlist = new Wishlist;
            $wishlist->client_id = $request->session()->get('client')['id'];
            $wishlist->product_id = $request->product_id;
            $wishlist->save();
            return redirect('/wishlistItems')->with('status', 'The product has been saved successfully in wishlist..!!');
        } else {
            return redirect('/login');
        }
    }

    public function wishlistItems() {

        $clientId = Session::get('client')['id'];
        $products = DB::table('wishlists')
        ->join('products', 'wishlists.product_id', '=', 'products.id')
        ->where('wishlists.client_id', $clientId)
        ->select('products.*', 'wishlists.id as wishlist_id')
        ->get();

        return view('client.wishlist')->with('products', $products);
    }

    public function remove_wishlist_item($id) {
        Wishlist::destroy($id);
        return back()->with('status', 'The product has been removed successfully from wishlist..!!');
    }

    public function addFeedback(Request $request) {
        $this->validate($request, ['feedback' => 'required']);

        if($request->session()->has('client')) {
            $comment = new Feedback;
            $comment->client_id = $request->session()->get('client')['id'];
            $comment->feedback = $request->feedback;
            $comment->status = 1;
            $comment->save();
            return back()->with('status', 'The Feedback has been posted successfully..!!');
        } else {
            return redirect('/login');
        }
    }

    public function feedback() {
        $feedbacks = DB::table('feedback')
        ->join('clients', 'feedback.client_id', '=', 'clients.id')
        ->select('clients.*', 'feedback.*')
        ->get();

        return view('admin.feedback')->with('feedbacks', $feedbacks);
    }

    public function delete_feedback($id) {
        $feedback = Feedback::find($id);

        $feedback->delete();

        return back()->with('status', 'The slider has been successfully deleted..!!');
    }

    public function activate_feedback($id) {
        $feedback = Feedback::find($id);

        $feedback->status = 1;
        $feedback->update();

        return back()->with('status', 'The feedback has been successfully activated..!!');
    }

    public function unactivate_feedback($id) {
        $feedback = Feedback::find($id);

        $feedback->status = 0;
        $feedback->update();

        return back()->with('status', 'The feedback has been successfully unactivated..!!');
    }

    public function addtocart($id) {
        $product = Product::find($id);

        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        Session::put('cart', $cart); 

        //dd(Session::get('cart'));
        return redirect('shop')->with('status', 'Product has been added to Cart successfully');
    }

    public function update_qty(Request $request, $id) {
        //print('the product id is '.$request->id.' And the product qty is '.$request->quantity);
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);

        $cart->updateQty($id, $request->quantity);
        Session::put('cart', $cart);

        //dd(Session::get('cart'));
        return back();
    }

    public function remove_from_cart($id) {

        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        
        $cart->removeItem($id);
       
        if(count($cart->items) > 0){
            Session::put('cart', $cart);
        }
        else{
            Session::forget('cart');
        }

        //dd(Session::get('cart'));
        return back();
    }

    public function cart() {
        if(!Session::has('cart')) {
            return view('client.cart');
        }
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        
        return view('client.cart', ['products' => $cart->items]);
    }

    public function checkout() {
        if(!Session::has('client')) {
            return view('client.login');
        }

        if(!Session::has('cart')) {
            return redirect('/cart')->with('warning', 'There is no item in your cart..!!!');
        }
        return view('client.checkout');
    }

    public function login() {
        return view('client.login');
    }

    public function logout() {
        Session::forget('client');

        return redirect('/shop');
    }

    public function signup() {
        return view('client.signup');
    }

    public function create_account(Request $request) {
        $this->validate($request, ['client_name' => 'required',
                                    'email' => 'email|required|unique:clients',
                                    'password' => 'required|min:5' ]);
        $client = new Client();
        $client->email = $request->email;
        $client->client_name = $request->client_name;
        $client->password = bcrypt($request->password);

        $client->save();

        return redirect('/login')->with('status', 'Your account has been successfully created...!!');
    }

    public function access_account(Request $request) {
        $this->validate($request, ['email' => 'email|required',
                                    'password' => 'required' ]);
        $client = Client::where('email', $request->email)->first();
        
        if($client) {
            if(Hash::check($request->password, $client->password)) {
                Session::put('client', $client);
                return redirect('/shop');
            } else {
                return back()->with('status', 'Wrong email or password');
            }
        } else {
            return back()->with('status', 'You do not have an account with this email');
        } 
    }

    public function postcheckout(Request $request) {
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);

        $this->validate($request, ['name' => 'required',
                                   'address' => 'required',
                                   'client_phone' => 'required|min:8|max:11']);

        $payer_id = time();

        $order = new Order();

        $order->name = $request->name;
        $order->address = $request->address;
        $order->client_phone = $request->client_phone;
        $order->client_id = $request->session()->get('client')['id'];
        $order->cart = serialize($cart);
        $order->payer_id = $payer_id;

        $order->save();

        Session::forget('cart');

        $orders = DB::table('orders')
        ->join('clients', 'orders.client_id', '=', 'clients.id')
        ->where('payer_id', $payer_id)
        ->select('clients.*', 'orders.*')
        ->get();

        $orders->transform(function($order, $key){
        $order->cart = unserialize($order->cart);

        return $order; 
        });

        $email = Session::get('client')->email;

        Mail::to($email)->send(new SendMail($orders));

        return redirect('/cart')->with('status', 'Your purchase has been successfully accomplished..!!');
    }

    public function orders() {
        $orders = DB::table('orders')
        ->join('clients', 'orders.client_id', '=', 'clients.id')
        ->select('clients.*', 'orders.*')
        ->get();

        $orders->transform(function($order, $key){
        $order->cart = unserialize($order->cart);

        return $order; 
        });

        return view('admin.orders')->with('orders', $orders); 
    }
}
