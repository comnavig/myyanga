<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
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
use App\ProductShipment;
use App\ProductFavourite;
use App\ProductReview;
use App\ProductSold;

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
            'action' => Rule::in(['approved', 'declined','suspended','delete']),
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			if ($request->action == "delete")
			{
				$listing = Listing::find($request->listing_id);
				
				if ($listing->status == "DECLINED")
				{
					foreach($listing->product as $product)
					{
						$productsold = ProductSold::where("product_id",$product->id)->get()->first();
						
						if (empty($productsold->id))
						{
								$product = Product::find($product->id);
								
								$pictures = ProductPicture::where('product_id', $product->id)->get();
									
								$i = 0;
								foreach ($pictures as $picture)
								{
									$pic = ProductPicture::find($picture['id']);
									
									if (!empty($pic->id))
									{
										$remove_old = explode('/', $pic->url);
										
										Storage::disk('do')->delete('products/'.last($remove_old));
										
										$pic->delete();
									}
								}
								
								$shipments = ProductShipment::where('product_id', $product->id)->delete();
								$favourites = ProductFavourite::where('product_id', $product->id)->delete();
								$reviews = ProductReview::where('product_id', $product->id)->delete();
								
								$product->delete();
						}
					}
					
					//Deleing listing details
					$urls = ListingUrl::where('listing_id', $listing->id)->delete();
					$phones = ListingPhone::where('listing_id', $listing->id)->delete();
					$emails = ListingEmail::where('listing_id', $listing->id)->delete();
					
					if (!empty($listing->logo))
					{
						$remove_old = explode('/', $listing->logo);
						
						Storage::disk('do')->delete('logo/'.last($remove_old));
						
					}
					
					$listing->delete();
				}
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

	public function edit($id)
	{
		$listing = Listing::find($id);
		$categories = Category::all();
		$locations = Location::all();
			
		if (empty($listing->id))
		{
			return back()->withErrors(['The selected listing does not exist.']);
		}
		else
		{
			if ($listing->status == "SUSPENDED")
			{
				return back()->withErrors(['The selected listing has been suspended and can not be edited.']);
			}
			else
			{
				return view('admin.listings.edit', ['listing' => $listing, 'locations' => $locations, 'categories' => $categories ]);
			}
			
		}
		
	}

	public function update(Request $request)
    {
		$user_id = Auth::id();
		
		$messages = [
								'logo.required' => 'Please upload your business logo',
								'name.required' => 'Please type in your business name',
								'cac.required' => 'Please indicate if your business is registered with CAC',
								'cac_no.required' => 'Please type in your CAC Registration Number',
								'description.required' => 'Please type in your business description',
								'location.required' => 'Please select a city',
								'location.exists' => 'Please select a valid city',
								'categories.*.required' => 'Please select a category',
								'categories.*.exists' => 'Please select a valid category',
								'links.*.required' => 'Please type in your business url.',
								'links.*.url' => 'Please type in a valid URL eg. http://business.ng',
								'pictures.*.required' => 'Please upload atleast a picture.',
								'emails.*.required' => 'Please type in your business email address.',
								'phones.*.required' => 'Please type in your business phone.',
								'phones.*.digits' => 'Please your business phone must be 11 digits.',
							];
							
		$customAttributes = [
											'links' => 'email address',
										];

		$validator = Validator::make($request->all(), [
			'logo' => 'nullable',
            'listing_id' => 'required|exists:listings,id',
            'cac' => 'required|string',
            'cac_no' => Rule::requiredIf($request->cac == "Yes"),
            'description' => 'required|string',
            'address' => 'required|string',
            'location' => 'required|exists:locations,id',
             'phones.*' => 'required',
            'emails.*' => 'email',
            'url.0' => 'url',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			
			$new_listing = Listing::find($request->listing_id);
			if (!empty($request->logo))
			{
			    $siteUrl = config('app.url'); 
				$remove_old = explode('/', $new_listing->logo);
				Storage::disk('public')->delete('logo/'.last($remove_old));
							
				// $temp = $request->file('logo')->store('public/temp');
				// $image_size = Storage::size($temp);
				
				$width = 200;
				
				$temp = $request->file('logo')->store('public/temp');
				// Handle file uploads (logo and pictures)
                $logoPath = $request->file('logo')->store('logo', 'public');
                
                $imageName = basename($temp);
				$image_size = Storage::size($temp);
				
				// $img = Image::make(url(Storage::url($temp)));
				
				// $img->resize($width, null, function ($constraint) {
																				// 			$constraint->aspectRatio();
																						  //});
				// $img->save(storage_path()."/app/".$temp, 100);
				
				// $path = Storage::disk('public')->putFile('logo',storage_path()."/app/".$temp);
				// $url = Storage::disk('public')->url($path);
				// Storage::delete($temp);
				
				// $new_listing->logo = $url;
				$new_listing->logo = $siteUrl . '/storage/' .$logoPath;
				
			}
			
			$new_listing->name = $request->name;
			$new_listing->description = $request->description;
			$new_listing->address = $request->address;
			$new_listing->cac = $request->cac;
			$new_listing->cac_no = (empty($request->cac_no) ? "NULL" : $request->cac_no );
			$new_listing->parent_id = 0;
			$new_listing->location_id = $request->location;
			// $new_listing->user_id = $user_id;
			$new_listing->status = "APPROVED";
			$new_listing->featured = "PENDING";
			$new_listing->save();
			
			
			//Email
			if (!empty($request->emails))
			{
				foreach($request->emails as $key => $email)
				{
					$new_email = ListingEmail::find($key);
					
					if (!empty($new_email->id))
					{
						$new_email->email = $email;
						$new_email->save();
					}
				}
			}
			
			//Phone
			if (!empty($request->phones))
			{
				foreach($request->phones as $key => $phone)
				{
					$new_phone = ListingPhone::find($key);
					
					if (!empty($new_phone->id))
					{
						$new_phone->phone = $phone;
						$new_phone->save();
					}
				}
			}
			
			
			//Url
			if (!empty($request->url))
			{
				foreach($request->url as $key => $url)
				{
					$new_url = ListingUrl::find($key);
					
					if (!empty($new_url->id))
					{
						$new_url->url = $url;
						$new_url->save();
					}
				}
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.listings');
			
		}
		
    }

	public function delete($id)
	{
		$order = Listing::where([ ['id',$id]])->get()->first();
		$products = Product::where('listing_id', $order->id)->get();
		
		if (empty($order->id))
		{
			return back()->withErrors(['You are not allowed to delete this Listing #'.$id]);
		}
		else
		{
		
			$products->each->delete();
			$order->delete();
			
			session()->flash('message', 'Listing #'.$id.' was deleted successful!');
			return back();
		}
		
	}
	
}
