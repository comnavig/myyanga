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
use App\ProductCategory;
use App\ProductFavourite;
use App\PostCategory;
use App\GroomTipCategory;
use App\FeaturedProduct;
use App\Location;
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
use App\Discover;
use App\DiscoverCategory;
use Vedmant\FeedReader\Facades\FeedReader;
use App\Mail\ProductNotification;
use App\Mail\PremiumNotification;
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
		
		$products = Product::where('status', 'APPROVED')->orderBy('id','desc')->get();
		
        return view('welcome', ['featuredcategories' => $featuredcategories, 'products' => $products ]);
    }
    
    public function tour()
    {
		$today = date("Y-m-d");
		
									
		$featuredcategories = FeaturedCategory::all();
		
		$products = Product::where('status', 'APPROVED')->orderBy('id','desc')->get();
		
        return view('tour', ['featuredcategories' => $featuredcategories, 'products' => $products ]);
    }
    
    public function today()
    {
		$today = date("Y-m-d");
		
									
		$featuredcategories = FeaturedCategory::all();
		
		$products = Product::where('status', 'APPROVED')->orderBy('id','desc')->get();
		
        return view('today', ['featuredcategories' => $featuredcategories, 'products' => $products ]);
    }
    
    public function page($slug)
    {
		$page = Page::where('slug', $slug)->get();
		
		if (empty($page[0]['id']))
		{
			$listing = Listing::where('slug', $slug)->get();
		
			if (empty($listing[0]['id']))
			{
				return view('404');
			}
			else
			{
				$products = Product::where([['listing_id', $listing[0]['id']],['status', 'APPROVED']])->get();
			
				return view('business.page', ['products' => $products, 'listing' => $listing[0] ]);
			}
		}
		else
		{
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

        if ($validator->fails()) 
        {
			$products = array();
			
			 return view('search.index', ['products' => $products, 'keyword' => "" ]);
        }
		else
		{
			$delimiter = array(" ", ",");
			$search_words = explode(" ", $request->search);
			
			$raw_products = array();
			$results = array();
			
			foreach($search_words as $word)
			{
				$listings = Listing::where('name', 'like', "%".$word."%")->get();
				$listings_id = array_column($listings->toArray(), 'id');
				
				$categories = Category::where('name', 'like', "%".$word."%")->get();
				$categories_id = array_column($categories->toArray(), 'id');
				
				$raw_products[0] = (!empty($categories_id) ? Product::whereIn('category_id', [$categories_id] )->orderBy('id','desc')->get() : array() ) ;
				$raw_products[1] = (!empty($listings_id) ? Product::whereIn('listing_id', [$listings_id] )->orderBy('id','desc')->get() : array() ) ;
				$raw_products[2] = Product::where([ ['name', 'like', "%".$word."%"], ['status', 'APPROVED'] ])->orderBy('id','desc')->get();
				$raw_products[3] = Product::where([ ['description', 'like', "%".$word."%"], ['status', 'APPROVED'] ])->orderBy('id','desc')->get();
				
				for ($i = 0; $i < count($raw_products); $i++)
				{
					foreach($raw_products[$i] as $product)
					{
						$results[] = $product;
					}
				}
			}
			
			return view('search.index', ['products' => array_unique($results), 'keyword' => $request->search ] );
		
		}
		
	}
	
	public function smart_search(Request $request)
	{
		$listings = Listing::all();
		$categories = Category::all();
		$products = array();
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
            'brands' => 'required|array',
            'categories' => 'required|array',
        ], $messages, $customAttributes);
		
		 $selected = array();
		 
		
        if ($validator->fails()) 
        {
			$selected['brands'] = array();
			$selected['categories'] = array();
			
			return view('search.smart', ['listings' => $listings, 'categories' => $categories, 'products' => $products, 'selected' => $selected ]);
		}
		else
		{
			$selected['brands'] = $request->brands;
			$selected['categories'] = $request->categories;
			
			$products = Product::whereIn( 'listing_id', $request->brands )->whereIn( 'category_id', $request->categories )->orderBy('id','desc')->get();
			
			return view('search.smart', ['listings' => $listings, 'categories' => $categories, 'products' => $products, 'selected' => $selected]);
		}
	}
	
	public function featured($cat, $id)
	{
		$featuredcategory = FeaturedCategory::find($cat);
		
		if (empty($featuredcategory->id))
		{
			return view('404');
		}
		else
		{
			
			$product = Product::where([ ['id', $id], ['status', 'APPROVED'] ])->get();
			
			if (empty($product[0]['id']))
			{
				return view('404');
			}
			else
			{
				return view('featured.product', ['product' => $product,  'category' => $featuredcategory ]);
			}
			
		}
	}
	
	public function featured_category($cat)
	{
		$category = FeaturedCategory::find($cat);
		if (empty($category->id))
		{
			return view('404');
		}
		else
		{
			//~ $featureds = $category->featured;
			//~ $products = Product::where('featured', $cat)->get();
		
			return view('featured.products', ['category' => $category]);
		}
		
	}
	
	public function product($slug, $product_slug)
	{
		$listing = Listing::where('slug', $slug)->get();
		
		if (empty($listing[0]['id']))
		{
			return view('404');
		}
		else
		{
			
			$product = Product::where([['listing_id', $listing[0]['id']],['slug', $product_slug], ['status', 'APPROVED']])->get();
			if (empty($product[0]['id']))
			{
				return view('404');
			}
			else
			{
				$products = Product::where([ ['listing_id', $listing[0]['id']], ['status', 'APPROVED'] ])->get();
				return view('product', ['product' => $product, 'products' => $products, 'listing' => $listing[0] ]);
			}
			
		}
			
		
	}
	
	public function explore()
	{
		$categories = Category::all();
		
		return view('explore.index', ['categories' => $categories->where('parent_id', 0),]);
	}
	
	public function explore_category($id)
	{
		$category = Category::find($id);
		if (empty($category->id))
		{
			return view('404');
		}
		else
		{
			$products = Product::where([['category_id', $id], ['status', 'APPROVED'] ])->get();
		
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
            'type.0' =>'required',
            'location' =>'required',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			foreach($request->type as $type)
			{
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

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$favourite = ProductFavourite::where([ ['product_id', $request->product_id], ['user_id', $user_id ] ])->get();
			$favourite = $favourite->last();
			
			if (empty($favourite->id))
			{
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

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$favourite = ListingFollow::where([ ['listing_id', $request->listing_id], ['user_id', $user_id ] ])->get();
			$favourite = $favourite->last();
			
			if (empty($favourite->id))
			{
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
		$pyls = PostYourLook::whereDate('expired_at','<', $today)->get();
		$current_pyls = PostYourLook::whereDate('expired_at','>', $today)->get();
		$latest = $current_pyls->last();
		$entries = UserPostYourLook::all();
		
		$refined_pyls = collect();
		
		foreach( $pyls as $pyl )
		{
			$refined_entries = collect();
			foreach($pyl->entries as $entry)
			{
				$data =  array('id' => $entry->id, 'photo' => $entry->photo, 'name' => $entry->user->name, 'date' => $entry->created_at->format("jS M Y h:iA"), 'votes_no' => $entry->votes->count(),);
				$refined_entries[] = (object) $data;
			}
			
			$data2 =  array('id' => $pyl->id, 'slug' => $pyl->slug, 'name' => $pyl->name, 'entries' => $refined_entries );
			
			$refined_pyls[] = (object) $data2;
		}
		
		
		return view('pyls.index', ['latest' => $latest, 'pyls' => $refined_pyls, 'pyl_page' => $pyl_page->last() ]);
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

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$userpyls = UserPostYourLook::where([ ['post_your_look_id', $request->pyl_id], ['user_id', $user_id ] ])->get();
			$userpyls = $userpyls->last();
			
			if (empty($userpyls->id))
			{
				$temp = $request->file('photo')->store('public/pyl');
				$path = Storage::disk('do')->putFile('pyl',storage_path()."/app/".$temp);
				$photo = Storage::disk('do')->url($path);
				Storage::delete($temp);
				
				$userpyl = new UserPostYourLook;
				$userpyl->photo = $photo;
				$userpyl->post_your_look_id = $request->pyl_id;
				$userpyl->user_id = $user_id;
				$userpyl->status = "PENDING";
				$userpyl->save();
				
				session()->flash('message', 'Your upload was successful!');
			}
			else
			{
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
		$entries =$pyl->entries;
		$refined_entries = collect();
		
		foreach($entries as $entry)
		{
			$data =  array('id' => $entry->id, 'photo' => $entry->photo, 'name' => $entry->user->name, 'date' => $entry->created_at->format("jS M Y h:iA"), 'votes_no' => $entry->votes->count(),);
			$refined_entries[] = (object) $data;
		}
		
		$userpyls = UserPostYourLook::where([ ['post_your_look_id', $pyl->id], ['user_id', $user_id ] ])->get();
		$userpyl = $userpyls->last() ?? collect();
		
		//~ return $refined_entries;
		return view('pyls.competition', ['pyl' => $pyl, 'entries' => $refined_entries, 'expired' => $expired, 'userpyl' => $userpyl ]);
	}
	
	public function pyl_entry($slug, $id)
	{
		$pyl = PostYourLook::where('slug', $slug)->get();
		$pyl = $pyl->last();
		
		$entry = UserPostYourLook::where([['post_your_look_id', $pyl->id], ['id', $id]])->get();
		
		return view('pyls.entry', ['pyl' => $pyl, 'entry' => $entry->last() ]);
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

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$uservotes = PostYourLookVote::where([ ['user_post_your_look_id', $request->upyl_id], ['user_id', $user_id ] ])->get();
			$uservotes = $uservotes->last();
			
			if (empty($uservotes->id))
			{
				$uservote = new PostYourLookVote;
				$uservote->user_post_your_look_id = $request->upyl_id;
				$uservote->user_id = $user_id;
				$uservote->save();
				
				session()->flash('message', 'Your vote was successful!');
			}
			else
			{
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
		
		if (empty($category->id))
		{
			return redirect()->route('premiums');
		}
		else
		{
			$premiums = Premium::where("premium_category_id", $id)->orderBy('id', 'desc')->paginate(20);
			
			return view('premiums.category', ['category' => $category, 'premiums' => $premiums]);
		}
		
	}
	
	public function premium_story($id)
	{
		$premiums = Premium::where('id', $id)->get();
		$premium = $premiums->last();
		
		if (empty($premium->id))
		{
			return back()->withErrors(['Does Not exist']);
		}
		else
		{
			$premiums = Premium::where("premium_category_id", $premium->premium_category_id)->orderby('id', 'desc')->get();
		
			return view('premiums.story',['premium' => $premium, 'premiums' => $premiums]);
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
		
		if (empty($category->id))
		{
			return redirect()->route('discovers');
		}
		else
		{
			$discovers = Discover::where("discover_category_id", $id)->orderBy('id', 'desc')->paginate(20);
			
			return view('discovers.category', ['category' => $category, 'discovers' => $discovers]);
		}
		
	}
	
	public function discover_story($slug)
	{
		$discovers = Discover::where('slug', $slug)->get();
		$discover = $discovers->last();
		
		if (empty($discover->id))
		{
			return back()->withErrors(['Does Not exist']);
		}
		else
		{
			$discovers = Discover::where("discover_category_id", $discover->discover_category_id)->orderby('id', 'desc')->get();
		
			return view('discovers.story',['discover' => $discover, 'discovers' => $discovers]);
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
		
		if (empty($category->id))
		{
			return redirect()->route('groomtips');
		}
		else
		{
			$groomingtips = GroomTips::where("category_id", $id)->orderBy('id', 'desc')->paginate(20);
			
			return view('groomingtips.category', ['category' => $category, 'groomingtips' => $groomingtips]);
		}
		
	}
	
	public function groomingtip_tip($slug)
	{
		$groomtips = GroomTips::where('slug', $slug)->get();
		$groomtip = $groomtips->last();
		
		if (empty($groomtip->id))
		{
			return back()->withErrors(['Does Not exist']);
		}
		else
		{
			$groomtips = GroomTips::where("category_id", $groomtip->category_id)->orderby('id', 'desc')->get();
		
			return view('groomingtips.show',['groomtip' => $groomtip, 'groomtips' => $groomtips]);
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
		
		if (empty($category->id))
		{
			return redirect()->route('tvs');
		}
		else
		{
			$tvs = Tv::where("tv_category_id", $id)->orderBy('id', 'desc')->paginate(20);
			
			return view('tvs.category', ['category' => $category, 'tvs' => $tvs]);
		}
		
	}
	
	public function myyangatv_show($id)
	{
		$tv = Tv::find($id);
		
		if (empty($tv->id))
		{
			return back()->withErrors(['Does Not exist']);
		}
		else
		{
			$tvs = Tv::where("tv_category_id", $tv->tv_category_id)->orderby('id', 'desc')->get();
		
			return view('tvs.show',['tv' => $tv, 'tvs' => $tvs]);
		}
		
	}
	
	//Blog
	public function blog()
	{
		$categories = PostCategory::all();
		
		return view('blog.index', ['categories' => $categories]);
	}
	
	public function blog_category($id)
	{
		$category = PostCategory::find($id);
		
		if (empty($category->id))
		{
			return redirect()->route('blog');
		}
		else
		{
			$posts = Post::where([ ["post_category_id", $id],["status", "APPROVED"] ])->orderBy('id', 'desc')->paginate(20);
			
			return view('blog.category', ['category' => $category, 'posts' => $posts]);
		}
		
	}
	
	public function blog_post($slug)
	{
		$post = Post::where('slug', $slug)->get();
		$post = $post->last();
		
		if (empty($post->id))
		{
			return redirect()->route('blog');
		}
		else
		{
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
	
	public function notify()
	{
		$users = User::where('type', 'INDIVIDUAL')->get();
		
		foreach($users as $user)
		{
			$notification = $user->notification;
			if (!empty($notification->id))
			{
				$days = json_decode($notification->days, true);
				$categories = json_decode($notification->categories, true);
				$listings = json_decode($notification->listings, true);
				$today = date("l");
				
				if (in_array($today, $days))
				{
					$user_listings = Listing::find($listings);
					$processed_listing = array();
					
					foreach($user_listings as $listing)
					{
						$products = Product::where('listing_id', $listing->id)->whereIn('category_id', [$categories])->orderBy('id','desc')->get();
						if ($products->count() > 0)
						{
							$processed_listing[$listing->id]['details'] = $listing;
							$processed_listing[$listing->id]['products'] = $products->take(5);
						}
						
						
					}
					
					$user['listings'] = $processed_listing;
					
					
					Mail::to($user->email)->send(new ProductNotification($user));
				}
			}
			
			$premium_subs = PremiumSubscription::where([ ['user_id', $user->id], ['status', 'PAID']])->get()->last();
			
			if (!empty($premium_subs->id))
			{
				if (!$premium_subs->daysOver($premium_subs->expiry))
				{
					$premiums = Premium::orderBy('id','desc')->get();
					$user['premiums'] = $premiums->take(10);
					
					Mail::to($user->email)->send(new PremiumNotification($user));
				}
			}
			
		}
		
	}
}
