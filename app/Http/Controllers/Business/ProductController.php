<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Location;
use App\ProductCategory;
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
    
    public function index()
    {
		$user_id = Auth::id();
		$products = Product::orderBy('id','desc')->get();
		
		return view('business.products.list', ['products' => $products->where('user_id', $user_id) ]);
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
		$categories = ProductCategory::all();
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
					$url = url(Storage::url($path));
					$new_picture = new ProductPicture;
					$new_picture->product_id = $new_product->id;
					$new_picture->url = $url;
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
		$categories = ProductCategory::all();
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
				$new_product->logo = url(Storage::url($path));
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
						
						$pic->url = url(Storage::url($path));
						$pic->save();
					}
					
				}
			}
			
			//Category
			if (!empty($request->categories))
			{
				foreach($request->categories as $key => $category)
				{
					$new_category = ProductCategory::find($key);
					
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
			$temp = $request->picture->store('public/temp');
			$path = Storage::disk('do')->putFile('deliverynote',storage_path()."/app/".$temp);
			$url = Storage::disk('do')->url($path);
			Storage::delete($temp);
			
			$deliverynote = new DeliveryNote;
			$deliverynote->product_sold_id = $request->product_sold_id;
			$deliverynote->image = $url;
			$deliverynote->delivery_note = $request->description;
			$deliverynote->user_id = $user_id;
			$deliverynote->admin_id = 0;
			$deliverynote->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('products.sold');
		}
		
	}
		
}
