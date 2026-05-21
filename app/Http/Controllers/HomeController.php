<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\Paginator;
use App\Category;
use App\FeaturedCategory;
use App\TvCategory;
use App\Listing;
use App\ListingCategory;
use App\ListingFollow;
use App\Product;
use App\ProductFavourite;
use App\PostCategory;
use App\GroomTipCategory;
use App\FeaturedProduct;
use App\Location;
use App\Area;
use App\PostYourLook;
use App\UserPostYourLook;
use App\PostYourLookVote;
use App\User;
use App\Tv;
use App\Post;
use App\GroomTips;
use App\Page;
use App\Premium;
use App\PremiumCategory;
use App\PremiumSubscription;
use App\NotificationData;
use App\Discover;
use App\DiscoverCategory;
use Vedmant\FeedReader\Facades\FeedReader;
use App\Mail\ProductNotification;
use App\Mail\PremiumNotification;
use App\Mail\NewPremiumNotification;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
    //~ public function __construct()
    //~ {
        //~ $this->middleware('auth');
    //~ }

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		$today = date("Y-m-d");


		$featuredcategories = FeaturedCategory::all();

		$products = Product::where('status', 'APPROVED')->orderBy('id', 'desc')->get();

		if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
			return view('welcome-old', ['featuredcategories' => $featuredcategories, 'products' => $products]);
			exit;
		}


		return view('welcome', ['featuredcategories' => $featuredcategories, 'products' => $products]);
	}

	public function index2()
	{
		$today = date("Y-m-d");


		$featuredcategories = FeaturedCategory::all();

		$products = Product::where('status', 'APPROVED')->orderBy('id', 'desc')->get();

		return view('welcome-old', ['featuredcategories' => $featuredcategories, 'products' => $products]);
	}

	public function tour()
	{
		$today = date("Y-m-d");


		$featuredcategories = FeaturedCategory::all();

		$products = Product::where('status', 'APPROVED')->orderBy('id', 'desc')->get();

		return view('tour', ['featuredcategories' => $featuredcategories, 'products' => $products]);
	}

	public function today()
	{
		$today = date("Y-m-d");


		$featuredcategories = FeaturedCategory::all();

		$products = Product::where('status', 'APPROVED')->orderBy('id', 'desc')->get();

		return view('today', ['featuredcategories' => $featuredcategories, 'products' => $products]);
	}

	public function page($slug)
	{
		$page = Page::where('slug', $slug)->get();

		if (empty($page[0]['id'])) {
			$listing = Listing::where([['slug', $slug], ['status', 'APPROVED']])->get();

			if (empty($listing[0]['id'])) {
				return view('rnf');
			} else {
				$products = Product::where([['listing_id', $listing[0]['id']], ['status', 'APPROVED']])->get();

				return view('business.page', ['products' => $products, 'listing' => $listing[0]]);
			}
		} else {
			return view('pages', ['page' => $page]);
		}
	}

	public function search(Request $request)
	{

		$messages = [
			'location.*.required' => 'Please select a city',
			'location.*.exists' => 'Please select a valid city',
			'category.*.required' => 'Please select a category',
			'category.*.exists' => 'Please select a valid category',
		];

		$customAttributes = [
			'links' => 'email address',
		];

		$validator = Validator::make($request->all(), [
			'search' => 'required',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			$products = array();

			return view('search.index', ['products' => $products, 'keyword' => ""]);
		} else {
			$delimiter = array(" ", ",");
			$search_words = explode(" ", $request->search);

			$raw_products = array();
			$results = array();

			foreach ($search_words as $word) {
				$listings = Listing::where('name', 'like', "%" . $word . "%")->get();
				$listings_id = array_column($listings->toArray(), 'id');

				$categories = Category::where('name', 'like', "%" . $word . "%")->get();
				$categories_id = array_column($categories->toArray(), 'id');

				$raw_products[0] = (!empty($categories_id) ? Product::whereIn('category_id', [$categories_id])->orderBy('id', 'desc')->get() : array());
				$raw_products[1] = (!empty($listings_id) ? Product::whereIn('listing_id', [$listings_id])->orderBy('id', 'desc')->get() : array());
				$raw_products[2] = Product::where([['name', 'like', "%" . $word . "%"], ['status', 'APPROVED']])->orderBy('id', 'desc')->get();
				$raw_products[3] = Product::where([['description', 'like', "%" . $word . "%"], ['status', 'APPROVED']])->orderBy('id', 'desc')->get();

				for ($i = 0; $i < count($raw_products); $i++) {
					foreach ($raw_products[$i] as $product) {
						$results[] = $product;
					}
				}
			}

			return view('search.index', ['products' => array_unique($results), 'keyword' => $request->search]);
		}
	}

	// 	public function smart_search(Request $request)
	// 	{
	// 		$listings = Listing::all();
	// 		$categories = Category::all();

	// 		$locations = Location::all();
	// 		// ddd($locations);

	// 		$products = array();
	// 		$messages = [
	// 								'location.*.required' => 'Please select a city',
	// 								'location.*.exists' => 'Please select a valid city',
	// 								'category.*.required' => 'Please select a category',
	// 								'category.*.exists' => 'Please select a valid category',
	// 							];

	// 		$customAttributes = [
	// 											'links' => 'email address',
	// 										];

	// 		$validator = Validator::make($request->all(), [
	//             'brands' => 'required_without:categories|array',
	//             'categories' => 'required_without:brands|array',
	//         ], $messages, $customAttributes);

	// 		 $selected = array();


	//         if ($validator->fails()) 
	//         {
	// 			$selected['brands'] = array();
	// 			$selected['categories'] = array();

	// 			return view('search.smart', ['listings' => $listings, 'categories' => $categories, 'locations' => $locations, 'products' => $products, 'selected' => $selected ]);
	// 		}
	// 		else
	// 		{
	// 			$selected['brands'] = $request->brands;
	// 			$selected['categories'] = $request->categories;

	// 			$products = Product::whereIn( 'listing_id', $request->brands )->whereIn( 'category_id', $request->categories )->orderBy('id','desc')->get();

	// 			return view('search.smart', ['listings' => $listings, 'categories' => $categories, 'locations' => $locations, 'products' => $products, 'selected' => $selected]);
	// 		}
	// 	}



	// public function smart_search(Request $request)
	// {
	//     // Paginate listings, categories, and locations to improve performance with large datasets
	//     $listings = Listing::paginate(10); // Adjust the number (10) based on your desired page size
	//     $categories = Category::paginate(10); // You can paginate categories as well
	//     $locations = Location::paginate(10); // You can paginate locations as well

	//     // Initialize validation messages
	//     $messages = [
	//         'location.*.required' => 'Please select a city',
	//         'location.*.exists' => 'Please select a valid city',
	//         'category.*.required' => 'Please select a category',
	//         'category.*.exists' => 'Please select a valid category',
	//         'brands.required_without' => 'At least one brand or category must be selected',
	//         'categories.required_without' => 'At least one brand or category must be selected',
	//     ];

	//     // Validator with more concise array rules and custom attributes
	//     $validator = Validator::make($request->all(), [
	//         'brands' => 'nullable|array',
	//         'categories' => 'nullable|array',
	//         'brands.*' => 'exists:brands,id',  // Validate individual brand IDs
	//         'categories.*' => 'exists:categories,id',  // Validate individual category IDs
	//     ], $messages);

	//     // Return early if validation fails
	//     if ($validator->fails()) {
	//         return view('search.smart', [
	//             'listings' => $listings, 
	//             'categories' => $categories, 
	//             'locations' => $locations, 
	//             'products' => [], 
	//             'selected' => [
	//                 'brands' => $request->brands ?? [],
	//                 'categories' => $request->categories ?? []
	//             ]
	//         ]);
	//     }

	//     // Prepare query for products
	//     $query = Product::query();

	//     // Only add filters if provided (avoid unnecessary whereIn calls)
	//     if ($brands = $request->brands) {
	//         // Ensure it's always an array (even if empty)
	//         $query->whereIn('listing_id', (array) $brands);
	//     }

	//     if ($categories = $request->categories) {
	//         // Ensure it's always an array (even if empty)
	//         $query->whereIn('category_id', (array) $categories);
	//     }

	//     // Paginate products to improve performance
	//     $products = $query->orderBy('id', 'desc')->paginate(10); // Paginate products as well (adjust the number as needed)

	//     // Return view with paginated data
	//     return view('search.smart', [
	//         'listings' => $listings,
	//         'categories' => $categories,
	//         'locations' => $locations,
	//         'products' => $products,
	//         'selected' => [
	//             'brands' => $request->brands ?? [],
	//             'categories' => $request->categories ?? []
	//         ]
	//     ]);
	// }


	public function smart_search(Request $request)
	{
		// Fetch only necessary data
		$listings = Listing::all();
		$categories = Category::all();
		$locations = Location::all();

		// Initialize validation messages
		$messages = [
			'location.*.required' => 'Please select a city',
			'location.*.exists' => 'Please select a valid city',
			'category.*.required' => 'Please select a category',
			'category.*.exists' => 'Please select a valid category',
			'brands.required_without' => 'At least one brand or category must be selected',
			'categories.required_without' => 'At least one brand or category must be selected',
		];

		$customAttributes = [
			'links' => 'email address',
		];

		// Validate request data
		$validator = Validator::make($request->all(), [
			'brands' => 'nullable|array',
			'categories' => 'nullable|array',
			'locations' => 'nullable|array',
			'categories.*' => 'exists:categories,id',
			'locations.*' => 'exists:locations,id', // Validate locations input
		], $messages, $customAttributes);

		// Initialize selected fields
		$selected = [
			'brands' => $request->brands ?? [],
			'categories' => $request->categories ?? [],
			'locations' => $request->locations ?? [],
		];

		// Return view with no results if validation fails
		if ($validator->fails()) {
			return view('search.smart', [
				'listings' => $listings,
				'categories' => $categories,
				'locations' => $locations,
				'products' => [],
				'selected' => $selected
			]);
		}

		// Build query with flexible conditions
		$query = Product::query();

		if (!empty($request->brands)) {
			$query->whereIn('listing_id', (array) $request->brands);
		}

		if (!empty($request->categories)) {
			$query->whereIn('category_id', (array) $request->categories);
		}

		// if (!empty($request->locations)) {
		//     $query->whereIn('location_id', (array) $request->locations); // Add location filter
		// }

		if (!empty($request->locations)) {
			// Join with the listings table to filter by location_id
			$query->whereHas('listing', function ($q) use ($request) {
				$q->whereIn('location_id', (array) $request->locations);
			});
		}

		// Paginate the query results
		$products = $query->orderBy('id', 'desc')->paginate(15);
		$products->appends($request->all());

		// Return view with paginated results
		return view('search.smart', [
			'listings' => $listings,
			'categories' => $categories,
			'locations' => $locations,
			'products' => $products,
			'selected' => $selected
		]);
	}




	// public function smart_search(Request $request)
	// {
	//     // Fetch only necessary data
	//     // $listings = Listing::all();
	//     // $categories = Category::all();
	//     // $locations = Location::all();

	//     // Paginate listings, categories, and locations to improve performance with large datasets
	//     $listings = Listing::paginate(10); // Adjust the number (10) based on your desired page size
	//     $categories = Category::paginate(10); // You can paginate categories as well
	//     $locations = Location::paginate(10);

	//     // Initialize validation messages
	//     $messages = [
	//         'location.*.required' => 'Please select a city',
	//         'location.*.exists' => 'Please select a valid city',
	//         'category.*.required' => 'Please select a category',
	//         'category.*.exists' => 'Please select a valid category',
	//         'brands.required_without' => 'At least one brand or category must be selected',
	//         'categories.required_without' => 'At least one brand or category must be selected',
	//     ];

	//     $customAttributes = [
	//         'links' => 'email address',
	//     ];

	//     // Validate request data
	//     $validator = Validator::make($request->all(), [
	//         'brands' => 'nullable|array',
	//         'categories' => 'nullable|array',
	//         // 'brands.*' => 'exists:brands,id', // Assuming 'brands' table has 'id' field
	//         'categories.*' => 'exists:categories,id', // Assuming 'categories' table has 'id' field
	//     ], $messages, $customAttributes);

	//     // Initialize selected fields
	//     $selected = [
	//         'brands' => $request->brands ?? [], // Ensures brands is always an array
	//         'categories' => $request->categories ?? [], // Ensures categories is always an array
	//     ];

	//     // Return view with no results if validation fails
	//     if ($validator->fails()) {
	//         return view('search.smart', [
	//             'listings' => $listings, 
	//             'categories' => $categories, 
	//             'locations' => $locations, 
	//             'products' => [], 
	//             'selected' => $selected
	//         ]);
	//     }

	//     // Build query with flexible conditions
	//     $query = Product::query();




	//     // Check if brands are selected, only apply the filter if valid
	//     if (!empty($request->brands)) {
	//         // Ensure that $request->brands is an array
	//         $query->whereIn('listing_id', (array) $request->brands);
	//     }

	//     // Check if categories are selected, only apply the filter if valid
	//     if (!empty($request->categories)) {
	//         // Ensure that $request->categories is an array
	//         $query->whereIn('category_id', (array) $request->categories);
	//     }

	//     // Execute the query and get the results
	//     // $products = $query->orderBy('id', 'desc')->get();
	//     $products = $query->orderBy('id', 'desc')->paginate(10); // Paginate products as well (adjust the number as needed)

	//     // Return view with results
	//     return view('search.smart', [
	//         'listings' => $listings,
	//         'categories' => $categories,
	//         'locations' => $locations,
	//         'products' => $products,
	//         'selected' => $selected
	//     ]);
	// }





	public function featured($cat, $id)
	{
		$featuredcategory = FeaturedCategory::find($cat);

		if (empty($featuredcategory->id)) {
			return view('404');
		} else {

			$product = Product::where([
				['id', $id],
				//   ['status', 'APPROVED'] 
			])->get();
			// 			dd($product);

			if (empty($product[0]['id'])) {
				return view('404');
			} else {
				return view('featured.product', ['product' => $product,  'category' => $featuredcategory]);
			}
		}
	}

	public function featured_category($cat)
	{
		$category = FeaturedCategory::find($cat);
		if (empty($category->id)) {
			return view('404');
		} else {
			//~ $featureds = $category->featured;
			//~ $products = Product::where('featured', $cat)->get();

			return view('featured.products', ['category' => $category]);
		}
	}

	public function product($slug, $product_slug)
	{
		$listing = Listing::where([['slug', $slug], ['status', 'APPROVED']])->get();

		if (empty($listing[0]['id'])) {
			return view('rnf');
		} else {

			$product = Product::where([['listing_id', $listing[0]['id']], ['slug', $product_slug], ['status', 'APPROVED']])->get();
			if (empty($product[0]['id'])) {
				return view('rnf');
			} else {
				$products = Product::where([['listing_id', $listing[0]['id']], ['status', 'APPROVED']])->get();
				return view('product', ['product' => $product, 'products' => $products, 'listing' => $listing[0]]);
			}
		}
	}

	public function explore()
	{
		$categories = Category::all();

		return view('explore.explore', ['categories' => $categories->where('parent_id', 0),]);
	}

	public function explore_category($id)
	{
		$category = Category::find($id);
		if (empty($category->id)) {
			return view('404');
		} else {
			$products = Product::where([['category_id', $id], ['status', 'APPROVED'], ['available', '1']])->get();

			return view('explore.products', ['category' => $category, 'products' => $products,]);
		}
	}



	public function make_notification(Request $request)
	{
		$messages = [
			'location.*.required' => 'Please select a city',
			'location.*.exists' => 'Please select a valid city',
			'type.*.required' => 'Please select a service',
			'category.*.exists' => 'Please select a valid category',
		];

		$customAttributes = [
			'links' => 'email address',
		];

		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'email' => 'required|email',
			//~ 'type.0' =>Rule::in(['discount', 'job', 'event', '']),
			'type.0' => 'required',
			'location' => 'required',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			foreach ($request->type as $type) {
				$location =  array('location' => $request->location);

				$notify = new Subscriber;
				$notify->name = $request->name;
				$notify->email = $request->email;
				$notify->type = $type;
				$notify->meta = json_encode($location);
				$notify->save();
			}
			session()->flash('message', 'Notification subscription was successful!');
			return redirect()->route('home');
		}
	}

	public function favourite(Request $request)
	{
		$user_id = Auth::id();
		$messages = [
			'location.*.required' => 'Please select a city',
			'location.*.exists' => 'Please select a valid city',
			'category.*.required' => 'Please select a category',
			'category.*.exists' => 'Please select a valid category',
		];

		$customAttributes = [
			'links' => 'email address',
		];

		$validator = Validator::make($request->all(), [
			'product_id' => 'required|exists:products,id',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$favourite = ProductFavourite::where([['product_id', $request->product_id], ['user_id', $user_id]])->get();
			$favourite = $favourite->last();

			if (empty($favourite->id)) {
				$new_favourite = new ProductFavourite;
				$new_favourite->product_id = $request->product_id;
				$new_favourite->user_id = $user_id;
				$new_favourite->save();
			}


			return back();
		}
	}

	public function follow(Request $request)
	{
		$user_id = Auth::id();
		$messages = [
			'location.*.required' => 'Please select a city',
			'location.*.exists' => 'Please select a valid city',
			'category.*.required' => 'Please select a category',
			'category.*.exists' => 'Please select a valid category',
		];

		$customAttributes = [
			'links' => 'email address',
		];

		$validator = Validator::make($request->all(), [
			'listing_id' => 'required|exists:listings,id',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$favourite = ListingFollow::where([['listing_id', $request->listing_id], ['user_id', $user_id]])->get();
			$favourite = $favourite->last();

			if (empty($favourite->id)) {
				$new_favourite = new ListingFollow;
				$new_favourite->listing_id = $request->listing_id;
				$new_favourite->user_id = $user_id;
				$new_favourite->save();
			}


			return back();
		}
	}

	public function pyl()
	{
		$pyl_page = Page::where('slug', "post_your_look")->get();
		$today = date("Y-m-d");
		$pyls = PostYourLook::whereDate('expired_at', '<', $today)->get();
		$current_pyls = PostYourLook::whereDate('expired_at', '>', $today)->get();
		$latest = $current_pyls->last();
		$entries = UserPostYourLook::all();

		$refined_pyls = collect();

		foreach ($pyls as $pyl) {
			$refined_entries = collect();
			foreach ($pyl->entries as $entry) {
				$data =  array('id' => $entry->id, 'photo' => $entry->photo, 'expiry' => $entry->expired_at, 'name' => $entry->user->name, 'date' => $entry->created_at->format("jS M Y h:iA"), 'votes_no' => $entry->votes->count(),);
				$refined_entries[] = (object) $data;
			}

			$data2 =  array('id' => $pyl->id, 'slug' => $pyl->slug, 'name' => $pyl->name, 'entries' => $refined_entries);

			$refined_pyls[] = (object) $data2;
		}


		return view('pyls.index', ['latest' => $latest, 'pyls' => $refined_pyls, 'pyl_page' => $pyl_page->last()]);
	}

	public function pyl_upload(Request $request)
	{
		$user_id = Auth::id();
		$messages = [
			'location.*.required' => 'Please select a city',
			'location.*.exists' => 'Please select a valid city',
			'category.*.required' => 'Please select a category',
			'category.*.exists' => 'Please select a valid category',
		];

		$customAttributes = [
			'links' => 'email address',
		];

		$validator = Validator::make($request->all(), [
			'pyl_id' => 'required|exists:post_your_looks,id',
			'photo' => 'required|image',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$userpyls = UserPostYourLook::where([['post_your_look_id', $request->pyl_id], ['user_id', $user_id]])->get();
			$userpyls = $userpyls->last();

			if (empty($userpyls->id)) {
				$path = $request->file('photo')->store('pyl', 'public');

				$userpyl = new UserPostYourLook;
				$userpyl->photo = $path;
				$userpyl->post_your_look_id = $request->pyl_id;
				$userpyl->user_id = $user_id;
				$userpyl->status = "PENDING";
				$userpyl->save();

				session()->flash('message', 'Your upload was successful!');
			} else {
				return back()->withErrors(['You can only post once per competition'])->withInput();
			}


			return back();
		}
	}

	public function pyl_competition($slug)
	{
		$user_id = Auth::id();
		$pyl = PostYourLook::where('slug', $slug)->get();
		$pyl = $pyl->last();

		$today = date_create('now');
		$expiry_date = date_create($pyl->expired_at);

		$expired = ($expiry_date > $today ? true : false);

		//~ $entries = UserPostYourLook::where('post_your_look_id', $pyl->id)->get();
		$entries = $pyl->entries;
		$refined_entries = collect();

		foreach ($entries as $entry) {
			$data =  array('id' => $entry->id, 'photo' => $entry->photo, 'name' => $entry->user->name, 'date' => $entry->created_at->format("jS M Y h:iA"), 'votes_no' => $entry->votes->count(),);
			$refined_entries[] = (object) $data;
		}

		$userpyls = UserPostYourLook::where([['post_your_look_id', $pyl->id], ['user_id', $user_id]])->get();
		$userpyl = $userpyls->last() ?? collect();

		//~ return $refined_entries;
		return view('pyls.competition', ['pyl' => $pyl, 'entries' => $refined_entries, 'expired' => $expired, 'userpyl' => $userpyl]);
	}

	public function pyl_entry($slug, $id)
	{
		$pyl = PostYourLook::where('slug', $slug)->get();
		$pyl = $pyl->last();

		$entry = UserPostYourLook::where([['post_your_look_id', $pyl->id], ['id', $id]])->get();

		return view('pyls.entry', ['pyl' => $pyl, 'entry' => $entry->last()]);
	}

	public function pyl_entry_vote(Request $request)
	{
		$user_id = Auth::id();
		$messages = [
			'location.*.required' => 'Please select a city',
			'location.*.exists' => 'Please select a valid city',
			'category.*.required' => 'Please select a category',
			'category.*.exists' => 'Please select a valid category',
		];

		$customAttributes = [
			'links' => 'email address',
		];

		$validator = Validator::make($request->all(), [
			'upyl_id' => 'required|exists:user_post_your_looks,id',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$uservotes = PostYourLookVote::where([['user_post_your_look_id', $request->upyl_id], ['user_id', $user_id]])->get();
			$uservotes = $uservotes->last();

			if (empty($uservotes->id)) {
				$uservote = new PostYourLookVote;
				$uservote->user_post_your_look_id = $request->upyl_id;
				$uservote->user_id = $user_id;
				$uservote->save();

				session()->flash('message', 'Your vote was successful!');
			} else {
				return back()->withErrors(['You can only vote once per competition'])->withInput();
			}


			return back();
		}
	}

	public function premiums()
	{
		//~ $tvs = Tv::orderby('id', 'desc')->paginate(12);

		//~ return view('tvs.index',['tvs' => $tvs]);

		$categories = PremiumCategory::all();

		return view('premiums.index', ['categories' => $categories]);
	}

	public function premium_category($id)
	{
		$category = PremiumCategory::find($id);

		if (empty($category->id)) {
			return redirect()->route('premiums');
		} else {
			$premiums = Premium::where("premium_category_id", $id)->orderBy('id', 'desc')->paginate(20);

			return view('premiums.category', ['category' => $category, 'premiums' => $premiums]);
		}
	}

	public function premium_story($id)
	{
		$premiums = Premium::where('id', $id)->get();
		$premium = $premiums->last();

		if (empty($premium->id)) {
			return back()->withErrors(['Does Not exist']);
		} else {
			$premiums = Premium::where("premium_category_id", $premium->premium_category_id)->orderby('id', 'desc')->get();

			return view('premiums.story', ['premium' => $premium, 'premiums' => $premiums]);
		}
	}


	public function discovers()
	{
		//~ $tvs = Tv::orderby('id', 'desc')->paginate(12);

		//~ return view('tvs.index',['tvs' => $tvs]);

		$categories = DiscoverCategory::all();

		return view('discovers.index', ['categories' => $categories]);
	}

	public function discover_category($id)
	{
		$category = DiscoverCategory::find($id);

		if (empty($category->id)) {
			return redirect()->route('discovers');
		} else {
			$discovers = Discover::where("discover_category_id", $id)->orderBy('id', 'desc')->paginate(20);

			return view('discovers.category', ['category' => $category, 'discovers' => $discovers]);
		}
	}

	public function discover_story($slug)
	{
		$discovers = Discover::where('slug', $slug)->get();
		$discover = $discovers->last();

		if (empty($discover->id)) {
			return back()->withErrors(['Does Not exist']);
		} else {
			$discovers = Discover::where("discover_category_id", $discover->discover_category_id)->orderby('id', 'desc')->get();

			return view('discovers.story', ['discover' => $discover, 'discovers' => $discovers]);
		}
	}

	public function groomingtip()
	{
		//~ $tvs = Tv::orderby('id', 'desc')->paginate(12);

		//~ return view('tvs.index',['tvs' => $tvs]);

		$categories = GroomTipCategory::all();

		return view('groomingtips.index', ['categories' => $categories]);
	}

	public function groomingtip_category($id)
	{
		$category = GroomTipCategory::find($id);

		if (empty($category->id)) {
			return redirect()->route('groomtips');
		} else {
			$groomingtips = GroomTips::where("category_id", $id)->orderBy('id', 'desc')->paginate(20);

			return view('groomingtips.category', ['category' => $category, 'groomingtips' => $groomingtips]);
		}
	}

	public function groomingtip_tip($slug)
	{
		$groomtip = GroomTips::where('slug', $slug)->with('picture')->first();

		if (empty($groomtip->id)) {
			return back()->withErrors(['Does Not exist']);
		} else {
			$groomtips = GroomTips::where("category_id", $groomtip->category_id)->with('picture')->orderby('id', 'desc')->get();

			return view('groomingtips.show', ['groomtip' => $groomtip, 'groomtips' => $groomtips]);
		}
	}

	public function myyangatv()
	{
		//~ $tvs = Tv::orderby('id', 'desc')->paginate(12);

		//~ return view('tvs.index',['tvs' => $tvs]);

		$categories = TvCategory::all();

		return view('tvs.index', ['categories' => $categories]);
	}

	public function myyangatv_category($id)
	{
		$category = TvCategory::find($id);

		if (empty($category->id)) {
			return redirect()->route('tvs');
		} else {
			$tvs = Tv::where("tv_category_id", $id)->orderBy('id', 'desc')->paginate(20);

			return view('tvs.category', ['category' => $category, 'tvs' => $tvs]);
		}
	}

	public function myyangatv_show($id)
	{
		$tv = Tv::find($id);

		if (empty($tv->id)) {
			return back()->withErrors(['Does Not exist']);
		} else {
			$tvs = Tv::where("tv_category_id", $tv->tv_category_id)->orderby('id', 'desc')->get();

			return view('tvs.show', ['tv' => $tv, 'tvs' => $tvs]);
		}
	}

	//Blog
	// 	public function blog()
	// 	{
	// 		$categories = PostCategory::all();
	// 		ddd($categories);

	// 		return view('blog.index2', ['categories' => $categories]);
	// 	}

	public function blog()
	{
		$posts = Post::all();
		$categories = PostCategory::all();
		// 		ddd($posts);

		return view('blog.index2', ['posts' => $posts, 'categories' => $categories]);
	}

	public function blog_category($id)
	{
		$category = PostCategory::find($id);

		if (empty($category->id)) {
			return redirect()->route('blog');
		} else {
			$posts = Post::where([["post_category_id", $id], ["status", "APPROVED"]])->orderBy('id', 'desc')->paginate(20);

			return view('blog.category', ['category' => $category, 'posts' => $posts]);
		}
	}

	public function blog_post($slug)
	{
		$post = Post::where('slug', $slug)->get();
		$post = $post->last();

		if (empty($post->id)) {
			return redirect()->route('blog');
		} else {
			$category = PostCategory::find($post->post_category_id);

			return view('blog.post', ['category' => $category, 'post' => $post]);
		}
	}

	public function blackops()
	{
		//~ $products = Product::all();

		//~ foreach($products as $product)
		//~ {
		//~ $product->slug = str_replace("/", "_",$product->slug);
		//~ $product->save();
		//~ }

		//~ return $products->fresh();


	}

	//~ public function slugmaker($name)
	//~ {
	//~ $name = str_replace(" ", "_", $name);
	//~ $name = strtolower($name);
	//~ $slugs = Product::where('slug', $name)->get();

	//~ return $name."_".($slugs->count()+rand(1000,9000));
	//~ }

	public function getImage($filename)
	{
		// Construct the full path to the image in storage/app/public/pictures
		$path = storage_path('app/public/temp/' . $filename);

		// Check if the file exists
		if (file_exists($path)) {
			// Serve the image using the Storage facade
			return response()->file($path);
		} else {
			// If the file doesn't exist, return a 404 response
			return abort(404);
		}
	}

	// 	public function notify()
	// 	{
	// 		$users = User::where('type', 'INDIVIDUAL')->orderBy('id','desc')->get();

	// 		foreach($users as $user)
	// 		{
	// 			$notification = $user->notification;

	// 			if (!empty($notification->id))
	// 			{
	// 				$days = json_decode($notification->days, true);
	// 				$categories = json_decode($notification->categories, true);
	// 				$listings = json_decode($notification->listings, true);
	// 				$today = date("l");
	// 				$yesterday = date('Y-m-d',strtotime("-1 days"));
	// 				$today_test = date('Y-m-d');

	// 				if (in_array($today, $days))
	// 				{
	// 					$user_listings = Listing::find($listings);
	// 					$processed_listing = array();

	// 					foreach($user_listings as $listing)
	// 					{
	// 						$products = Product::where('listing_id', $listing->id)->whereIn('category_id', [$categories])->whereDate('created_at', $today_test)->orderBy('id','desc')->get();

	// 						if ($products->count() > 0)
	// 						{
	// 						    //ddd($products);
	// 							$processed_listing[$listing->id]['details'] = $listing;
	// 							$processed_listing[$listing->id]['products'] = $products->take(5);
	// 						}


	// 					}

	// 					if ($products->count() > 0)
	// 					{
	// 						$user['listings'] = $processed_listing;

	// 						Mail::to($user->email)->send(new ProductNotification($user));
	// 					}
	// 				}
	// 			}

	// 			$premium_subs = PremiumSubscription::where([ ['user_id', $user->id], ['status', 'PAID']])->get()->last();
	// 			if (!empty($premium_subs->id))
	// 			{

	// 				if (!$premium_subs->daysOver($premium_subs->expiry))
	// 				{

	// 					$premiums = Premium::whereDate('created_at', $yesterday)->orderBy('id','desc')->get();


	// 					if ($premiums->count() > 0)
	// 					{
	// 						$user['premiums'] = $premiums->take(10);

	// 						Mail::to($user->email)->send(new PremiumNotification($user));
	// 					} 
	// 				}
	// 			}

	// 		}

	// 		return "Notifications Sent Successfully!";

	// 	}

	public function notify()
	{
		$users = User::where('type', 'INDIVIDUAL')->orderBy('id', 'desc')->get();

		foreach ($users as $user) {
			$notification = $user->notification;

			// DEBUGGING: Skip users with ID not equal to 4794 (scientistdsk@gmail.com)
			$debugUserId = 4794;
			if ($debugUserId !== null && $user->id != $debugUserId) {
				continue;
			}

			logger('DEBUG SESSION', ['user_id' => $user->id]);

			if ($notification && !empty($notification->id)) {
				logger('Processing Notification', ['user_id' => $user->id, 'notification_id' => $notification->id]);
				$days = json_decode($notification->days, true);
				$days = is_array($days) ? $days : [];
				$categories = json_decode($notification->categories, true);
				$listings = json_decode($notification->listings, true);
				$today = date("l");
				$yesterday = date('Y-m-d', strtotime("-1 days"));
				$twentyFourMonths = date('Y-m-d', strtotime("-24 months"));

				if (in_array($today, $days)) {
					$user_listings = is_array($listings) ? Listing::find($listings) : collect();
					$processed_listing = array();
					$hasProducts = false;

					foreach ($user_listings as $listing) {
						$products = Product::where('listing_id', $listing->id)
							->whereIn('category_id', $categories) // Ensure $categories is not wrapped in array
							->whereDate('created_at', '>=', $twentyFourMonths)
							->orderBy('id', 'desc')
							->get();

						if ($products->isNotEmpty()) {
							$processed_listing[$listing->id]['details'] = $listing;
							$processed_listing[$listing->id]['products'] = $products->take(5);
							$hasProducts = true;
						}
					}

					if ($hasProducts) {
						$user->listings = $processed_listing; // for email
						Mail::to($user->email)->send(new ProductNotification($user));
						unset($user->listings);
					}
				}
			}

			logger('Running Premium Notifications for user ID: ' . $user->id);

			$premium_subs = PremiumSubscription::where([['user_id', $user->id], ['status', 'PAID']])->latest()->first();
			if (!empty($premium_subs->id)) {
				if (!$premium_subs->daysOver($premium_subs->expiry)) {

					// Fetch the user's existing notification list (assumed to be in JSON format)
					$notificationList = json_decode($user->notificationList, true); // Decode the JSON

					// If the list doesn't exist or isn't an array, initialize it
					if (!is_array($notificationList)) {
						$notificationList = [];
					}

					$premiums = Premium::whereDate('created_at', '>=', $twentyFourMonths)->orderBy('id', 'desc')->get();

					$premiumIds = Premium::whereDate('created_at', '>=', $twentyFourMonths)
						->whereNotIn('id', $notificationList)
						->inRandomOrder()
						->take(5)
						->pluck('id')
						->toArray();

					if (!empty($premiumIds)) {


						$notification = new NotificationData();
						$notification->user_id = $user->id; // Assign the user_id from $user
						$notification->premium_ids = json_encode($premiumIds); // Assuming $premiumIds is an array, encode it to store as JSON
						$notification->created_at = now(); // Laravel's helper for current timestamp

						$notification->save();

						$newNotificationId = $notification->id;

						// Append the new premium IDs to the existing list
						$notificationList = array_merge($notificationList, $premiumIds);

						// Update the user's notification list
						$user->notificationList = json_encode($notificationList); // Encode back to JSON
						$user->save();

						$user['newNotificationId'] = $newNotificationId;

						if ($premiums->isNotEmpty()) {
							$user['premiums'] = $premiums->take(10);
						}

						Mail::to($user->email)->send(new PremiumNotification($user));
					}
				}
			}
		}

		return "Notifications Sent Successfully!";
	}
}
