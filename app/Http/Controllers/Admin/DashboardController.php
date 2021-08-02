<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Listing;
use App\Product;
use App\ProductSold;
use App\UserPostYourLook;
use App\User;
use App\Order;
use App\Premium;
use App\PremiumSubscription;

class DashboardController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$user_id = Auth::id();
		$users = User::all();
		
		$listings = Listing::orderby('id', 'DESC')->get();
		
		$products = Product::orderby('id', 'DESC')->get();
		
		$ply_uploads = UserPostYourLook::orderby('id', 'DESC')->get();
		
		$products_sold = ProductSold::orderby('id', 'DESC')->get();
		
		$orders = Order::orderby('id', 'DESC')->get();
		
		$premia = Premium::orderby('id', 'DESC')->get();
		
		$premium_subscriptions = PremiumSubscription::orderby('id', 'DESC')->get();
		
		return view('admin.dashboard', [ 'users' => $users, 'listings' => $listings, 'products' => $products, 'products_sold' => $products_sold, 'ply_uploads' => $ply_uploads, 'orders' => $orders, 'premia' => $premia, 'premium_subscriptions' => $premium_subscriptions]);
        
    }
    
    public function individual_users()
    {
		$user_id = Auth::id();
		$users = User::where('type','INDIVIDUAL')->get();
		return view('admin.users.individual', [ 'users' => $users]);
        
    }
    
    public function business_users()
    {
		$user_id = Auth::id();
		$users = User::where('type','BUSINESS')->get();
		return view('admin.users.business', [ 'users' => $users]);
        
    }
    
    public function premium_subscriptions()
    {
		$premium_subscriptions = PremiumSubscription::orderby('id', 'DESC')->get();
		
		return view('admin.users.subscriptions', ['premium_subscriptions' => $premium_subscriptions]);
	}
    
}
