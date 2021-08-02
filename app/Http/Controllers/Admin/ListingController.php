<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Plan;
use App\Location;
use App\Category;
use App\Listing;
use App\Picture;
use App\ListingCategory;
use App\ListingUrl;
use App\ListingPhone;
use App\ListingEmail;
use App\Subscription;
use App\Product;
use App\FeaturedCategory;
use App\FeaturedProduct;
use App\ProductCategory;
use App\ProductSubcategory;
use App\ProductPicture;

class ListingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function index()
    {
		$user_id = Auth::id();
		$listings = Listing::all();
		
		return view('admin.listings.index', ['listings' => $listings->where('parent_id', 0)]);
	}
    
    public function products($id)
    {
		$user_id = Auth::id();
		$featuredCategories = FeaturedCategory::all();
		$listing = Listing::find($id);
		$products = Product::where('listing_id', $listing->id)->paginate(10);
		return view('admin.listings.products', ['listing' => $listing, 'products' => $products, 'featuredCategories' => $featuredCategories]);
	}
	
	public function view($id)
	{
		$listing = Listing::find($id);
		
		if (empty($listing->id))
		{
			return back()->withErrors(['the selected Listing do not exist!']);
		}	
		else
		{
			return view('admin.listings.view', ['listing' => $listing, 'backurl' => route('admin.listings')]);
		}
	}
	
	public function branch_view($id)
	{
		$listing = Listing::find($id);
		
		if (empty($listing->id))
		{
			return back()->withErrors(['the selected Listing do not exist!']);
		}	
		else
		{
			return view('admin.listings.view', ['listing' => $listing, 'backurl' => route('admin.listing.branch',['id' => $listing->parent_id] )]);
		}
	}
	
	public function action(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'listing_id' => 'required|exists:listings,id',
            'action' => Rule::in(['approved', 'declined','suspended']),
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$action = strtoupper($request->action);
			
			$listing = Listing::find($request->listing_id);
			$listing->status = $action;
			$listing->save();
			
			foreach($listing->product as $product)
			{
				$product = Product::find($product->id);
				$product->status = $action;
				$product->save();
			}
		}
		
		return redirect()->route('admin.listings');
	}
	
	public function featured(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'listing_id' => 'required|exists:listings,id',
            'featured' => Rule::in(['approved', 'pending']),
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$action = strtoupper($request->featured);
			
			$listing = Listing::find($request->listing_id);
			$listing->featured = $action;
			$listing->save();
		}
		
		return redirect()->route('admin.listings');
	}
	
}
