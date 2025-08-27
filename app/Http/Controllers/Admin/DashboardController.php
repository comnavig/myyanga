<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Listing;
use App\Product;
use App\ProductSold;
use App\UserPostYourLook;
use App\User;
use App\Settings;
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
    
    public function delete_individual_users($id)
	{
		$user = User::where([ ['id',$id]])->get()->first();
		
		if (empty($user->id))
		{
			return back()->withErrors(['You are not allowed to delete this User #'.$id]);
		}
		else
		{
			$user->delete();
			
			session()->flash('message', 'User #'.$id.' was deleted successful!');
			return back();
		}
		
	}
	
	public function delete_business_users($id)
	{
		$user = User::where([ ['id',$id]])->get()->first();
		
		
		
		if (empty($user->id))
		{
			return back()->withErrors(['You are not allowed to delete this Business #'.$id]);
		}
		else
		{
		    $listings = Listing::where('user_id', $user->id)->get();
		    foreach($listings as $listing){
		        $products = Product::where('listing_id', $listing->id)->get();
		        $products->each->delete();
		    }
		    $listings->each->delete();
			$user->delete();
			
			session()->flash('message', 'Business #'.$id.' and was deleted successful!');
			return back();
		}
		
	}
    
    public function business_users()
    {
		$user_id = Auth::id();
		$users = User::where('type','BUSINESS')->get();
		return view('admin.users.business', [ 'users' => $users]);
        
    }
    
    public function premium_subscriptions()
    {
		$premium_subscriptions = DB::table('premium_subscriptions')
        ->join('users', 'premium_subscriptions.user_id', '=', 'users.id')
        ->select('premium_subscriptions.*', 'users.name as user_name', 'users.email as user_email', 'users.mobile as user_mobile', 'users.whatsapp as user_whatsapp')
        ->orderBy('premium_subscriptions.id', 'DESC')
        ->get();
        
        $raw_settings = Settings::where('name','subscription_notification_text')->get();
        $settings = $raw_settings->last();
		
// 		dd($premium_subscriptions);
		
		return view('admin.users.subscriptions', ['premium_subscriptions' => $premium_subscriptions, 'settings' => $settings]);
	}
    
}
