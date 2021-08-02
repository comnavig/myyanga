<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Listing;
use App\Product;
use App\ProductSold;
use App\User;

class DashboardController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','only.business','verified']);
    }
    
    public function index()
    {
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$listings = Listing::where('user_id', $user_id)->get();
		
		$products = Product::where('user_id', $user_id)->orderby('id', 'DESC')->get();
		
		$products_id = array_column($products->toArray(), 'id');
		
		$products_sold = ProductSold::whereIn('product_id', $products_id )->get();
		
		return view('business.dashboard', [ 'user' => $user, 'listings' => $listings, 'products' => $products, 'products_sold' => $products_sold]);
	}
}
