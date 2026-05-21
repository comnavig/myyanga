<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Location;
use App\Category;
use App\Product;
use App\ProductSold;
use App\DeliveryNote;
use App\ProductPicture;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','only.business','verified']);
    }
    
    //original code
//     public function index()
//     {
// 		$user_id = Auth::id();
// 		$products = Product::orderBy('id','desc')->get();
		
// 		return view('business.products.list', ['products' => $products->where('user_id', $user_id) ]);
// 	}
	
// 	public function index(Request $request)
// {
//     $user_id = Auth::id();
    
//     // $perPage = $request->get('per_page', 10); // Default to 10 if no 'per_page' is provided
//      // Build query with flexible conditions
//     $query = Product::query();
    
//     // $products = Product::where('user_id', $user_id)->orderBy('id', 'desc')->paginate($perPage);
//     // Paginate the query results
//     $products = $query->orderBy('id', 'desc')->paginate(15);
//     $products->appends($request->all());
    
//     return view('business.products.list', ['products' => $products->where('user_id', $user_id) ]);
// }

	//max New Code
// 	public function index()
// {
//     $user_id = Auth::id();
//     $products = Product::where('user_id', $user_id)->orderBy('id', 'desc')->paginate(20); // Adjust the number per page as needed
    
//     return view('business.products.list', ['products' => $products]);
// }

// public function index(Request $request)
// {
//     $query = Product::where('user_id', Auth::id());

//     if ($search = $request->input('search')) {
//         $query->where('name', 'like', "%{$search}%");
//     }

//     $products = $query->orderBy('id', 'desc')->paginate(20);
//     return view('business.products.list', compact('products'));
// }

public function index(Request $request)
{
    $query = Product::where('user_id', Auth::id());

    if ($search = $request->input('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $products = $query->orderBy('id', 'desc')->paginate(20);

    return view('business.products.list', ['products' => $products]);
}



	public function sold()
	{
		$user_id = Auth::id();
		$products = Product::where('user_id', $user_id)->orderby('id', 'DESC')->get();
		
		$products_id = array_column($products->toArray(), 'id');
		
		$products_sold = ProductSold::whereIn('product_id', $products_id )->get();
		
		return view('business.products.sold', ['products_sold' => $products_sold]);

	}
	
	public function create()
	{
		$categories = Category::all();
		$locations = Location::all();

        return view('user.products.create', ['locations' => $locations, 'categories' => $categories ]);
			
	}
	
	public function add(Request $request)
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
            'name' => 'required|string',
            'price' => 'required',
             'categories.0' => 'exists:categories,id',
             'location' => 'required|exists:locations,id',
            'pictures.0' => 'required|mimes:jpeg,bmp,png',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_product = new Product;
			$new_product->name = $request->name;
			$new_product->description = $request->description;
			$new_product->price = $request->price;
			$new_product->location_id = $request->location;
			$new_product->category_id = $request->categories[0];
			$new_product->user_id = $user_id;
			$new_product->status = "PENDING";
			$new_product->save();
			
			//Pictures
			for ($i = 0; $i < 4; $i++)
			{
				if (!empty($request->pictures[$i]))
				{
					$picture = $request->pictures[$i];
					$path = $picture->store('public/pictures');
					$new_picture = new ProductPicture;
					$new_picture->product_id = $new_product->id;
					$new_picture->url = $path;
					$new_picture->save();
				}
				else
				{
					$new_picture = new ProductPicture;
					$new_picture->product_id = $new_product->id;
					$new_picture->url = "https://via.placeholder.com/250";
					$new_picture->save();
				}
					
					
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('products');
			
		}
		
    }
	
	public function edit($id)
	{
		$product = Product::find($id);
		$categories = Category::all();
		$locations = Location::all();
			
		if (empty($product->id))
		{
			return back()->withErrors(['The selected product does not exist.']);
		}
		else
		{
			if ($product->status == "SUSPENDED")
			{
				return back()->withErrors(['The selected product has been suspended and can not be edited.']);
			}
			else
			{
				return view('user.products.edit', ['product' => $product, 'locations' => $locations, 'categories' => $categories ]);
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
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'cac' => 'required|string',
            'cac_no' => Rule::requiredIf($request->cac == "Yes"),
            'description' => 'required|string',
            //~ 'phones.*' => 'required',
            //~ 'links.*' => 'required|bail|url',
            'plan' => 'required|exists:plans,id',
            'ot.*' => 'required',
            //~ 'categories.*' => 'required|exists:categories,id',
            'location' => 'required|exists:locations,id',
            //~ 'pictures.*' => 'required|mimes:jpeg,bmp,png',
            //~ 'emails.*' => 'required',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			
			$new_product = Product::find($request->product_id);
			if (!empty($request->logo))
			{
				$path = $request->file('logo')->store('public/pictures');
				$new_product->logo = $path;
			}
			
			$new_product->name = $request->name;
			$new_product->description = $request->description;
			$new_product->address = $request->address;
			$new_product->cac = $request->cac;
			$new_product->cac_no = (empty($request->cac_no) ? "NULL" : $request->cac_no );
			$new_product->operating_time = json_encode($request->ot);
			$new_product->parent_id = 0;
			$new_product->location_id = $request->location;
			$new_product->plan_id = $request->plan;
			$new_product->user_id = $user_id;
			$new_product->status = "PENDING";
			$new_product->featured = "PENDING";
			$new_product->save();
			
			$plan = Plan::find($request->plan);
			
			
			//Pictures
			if (!empty($request->pictures ))
			{
				foreach ($request->pictures as $key => $picture)
				{
					$pic = Picture::find($key);
					
					if (!empty($pic->id))
					{
						$path = $picture->store('public/pictures');
						
						$pic->url = $path;
						$pic->save();
					}
					
				}
			}
			
			//Category
			if (!empty($request->categories))
			{
				foreach($request->categories as $key => $category)
				{
					$new_category = Category::find($key);
					
					if (!empty($new_category->id))
					{
						$new_category->category_id = $category;
						$new_category->save();
					}
				}
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('products');
			
		}
		
    }
    
    public function add_delivery_note(Request $request)
    {
		$user_id = Auth::id();
		
		$validator = Validator::make($request->all(), [
            'product_sold_id' => 'required|exists:product_solds,id',
            'picture' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$path = $request->picture->store('deliverynote', 'public');
			
			$deliverynote = new DeliveryNote;
			$deliverynote->product_sold_id = $request->product_sold_id;
			$deliverynote->image = $path;
			$deliverynote->delivery_note = $request->description;
			$deliverynote->user_id = $user_id;
			$deliverynote->admin_id = 0;
			$deliverynote->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('products.sold');
		}
		
	}
	
// 	bulk Delete added by Max
// public function bulkDelete(Request $request)
// {
//     $ids = explode(',', $request->input('product_ids', ''));
//     Product::whereIn('id', $ids)->delete();

//     $user_id = Auth::id();
//     $perPage = 20;

//     // Get current page from request (default to 1)
//     $currentPage = $request->input('page', 1);

//     // How many total products are left
//     $totalProducts = Product::where('user_id', $user_id)->count();
//     $lastPage = ceil($totalProducts / $perPage);

//     // If current page is now beyond the last page, redirect to last valid page
//     $targetPage = ($currentPage > $lastPage) ? $lastPage : $currentPage;

//     return redirect()->route('products', ['page' => $targetPage])->with('success', 'Selected products deleted successfully..');
// }


// public function bulkDelete(Request $request)
// {
//     $productIds = explode(',', $request->input('product_ids'));

//     // Optional: Validate IDs exist and belong to the user
//     Product::whereIn('id', $productIds)
//         ->where('user_id', Auth::id())
//         ->delete();

//     return redirect()->route('listings.products', [
//         'q' => $request->input('q'),
//         'page' => $request->input('page', 1)
//     ])->with('success', 'Selected products deleted successfully.');
// }





public function bulkDeleteProducts(Request $request)
{
    // ✅ 1. Get the authenticated user ID
    $userId = Auth::id();

    // ✅ 2. Convert comma-separated product IDs into an array
    $productIds = explode(',', $request->input('product_ids', ''));

    // ✅ 3. Delete only the products that belong to the current user
    Product::whereIn('id', $productIds)
        ->where('user_id', $userId)
        ->delete();

    // ✅ 4. Get the search query and current page from the request
    $query = $request->input('search'); // search term
    $currentPage = (int) $request->input('page', 1); // page before deletion
    $perPage = 20; // number of products per page

    // ✅ 5. Count how many products remain that match the search query (if any)
    $queryBuilder = Product::where('user_id', $userId);
    if (!empty($query)) {
        $queryBuilder->where('name', 'like', '%' . $query . '%');
    }
    $totalMatchingProducts = $queryBuilder->count();

    // ✅ 6. Determine last valid page number after deletion
    $lastPage = max(ceil($totalMatchingProducts / $perPage), 1);

    // ✅ 7. Set final target page (in case current page became invalid)
    $targetPage = min($currentPage, $lastPage);
    
    
//     dd([
//     'search' => $query,
//     'page_from_request' => $request->input('page'),
//     'calculated_target_page' => $targetPage,
//     'route' => route('products', ['q' => $query, 'page' => $targetPage]),
// ]);


    // ✅ 8. Redirect to the products route with `q` and corrected `page`
    return redirect()->route('products', [
        'search' => $query,
        'page' => $targetPage
    ])->with('success', 'Selected products deleted successfully.');
}





		
}
