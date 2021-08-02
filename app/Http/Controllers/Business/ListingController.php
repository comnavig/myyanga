<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use App\Location;
use App\Category;
use App\Listing;
use App\ListingEmail;
use App\ListingPhone;
use App\ListingUrl;
use App\Product;
use App\ProductPicture;
use App\ProductShipment;

class ListingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','only.business','verified']);
    }
    
    public function index()
    {
		$user_id = Auth::id();
		$listings = Listing::where('parent_id', 0)->get();
		
		return view('business.listings.index', ['listings' => $listings->where('user_id', $user_id) ]);
	}
	
	public function create()
	{
		$locations = Location::all();

        return view('business.listings.create', ['locations' => $locations]);
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
            'logo' => 'required',
            'name' => 'required|string|unique:listings,name',
            'slug' => 'required|string|min:8',//|unique:listings,slug|unique:pages,slug',
            'cac' => 'required|string',
            'cac_no' => Rule::requiredIf($request->cac == "Yes"),
            'description' => 'required|string',
            'address' => 'required|string',
            'phones.0' => 'required',
            'location' => 'required|exists:locations,id',
            'emails.0' => 'email',
            'url.0' => 'url',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$slug = Listing::where('slug', $this->slug_format($request->slug))->get();
			
			if (empty($slug[0]['id']))
			{
				$temp = $request->file('logo')->store('public/temp');
				$image_size = Storage::size($temp);
				
				$width = 200;
				
				$img = Image::make(url(Storage::url($temp)));
				
				$img->resize($width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
				$img->save(storage_path()."/app/".$temp, 100);
				
				$path = Storage::disk('do')->putFile('logo',storage_path()."/app/".$temp);
				$url = Storage::disk('do')->url($path);
				Storage::delete($temp);
				
				
				$new_listing = new Listing;
				$new_listing->logo = $url;
				$new_listing->name = $request->name;
				$new_listing->slug = $this->slug_format($request->slug);
				$new_listing->description = $request->description;
				$new_listing->address = $request->address;
				$new_listing->cac = $request->cac;
				$new_listing->cac_no = (empty($request->cac_no) ? "NULL" : $request->cac_no );
				$new_listing->parent_id = 0;
				$new_listing->location_id = $request->location;
				$new_listing->user_id = $user_id;
				$new_listing->status = "PENDING";
				$new_listing->featured = "PENDING";
				$new_listing->save();
				
				//Email
				for ($i = 0; $i < 1; $i++)
				{
					
					$new_email = new ListingEmail;
					$new_email->listing_id = $new_listing->id;
					$new_email->email = $request->emails[$i];
					$new_email->save();
					
					
				}
				
				//Phone
				for ($i = 0; $i < 1; $i++)
				{
					
					$new_phone = new ListingPhone;
					$new_phone->listing_id = $new_listing->id;
					$new_phone->phone = $request->phones[$i];
					$new_phone->save();
					
				}
				
				//URL
				for ($i = 0; $i < 1; $i++)
				{
					
					$new_url = new ListingUrl;
					$new_url->listing_id = $new_listing->id;
					$new_url->url = $request->url[$i];
					$new_url->save();
					
				}
				
				session()->flash('message', 'Task was successful!');
				return redirect()->route('listings');
				
			}
			else
			{
				return back()->withErrors("Slug already taken, please pick a new slug")->withInput();
			}
		}
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
				return view('business.listings.edit', ['listing' => $listing, 'locations' => $locations, 'categories' => $categories ]);
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
				$remove_old = explode('/', $new_listing->logo);
				Storage::disk('do')->delete('logo/'.last($remove_old));
							
				$temp = $request->file('logo')->store('public/temp');
				$image_size = Storage::size($temp);
				
				$width = 200;
				
				$img = Image::make(url(Storage::url($temp)));
				
				$img->resize($width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
				$img->save(storage_path()."/app/".$temp, 100);
				
				$path = Storage::disk('do')->putFile('logo',storage_path()."/app/".$temp);
				$url = Storage::disk('do')->url($path);
				Storage::delete($temp);
				
				$new_listing->logo = $url;
			}
			
			$new_listing->description = $request->description;
			$new_listing->address = $request->address;
			$new_listing->cac = $request->cac;
			$new_listing->cac_no = (empty($request->cac_no) ? "NULL" : $request->cac_no );
			$new_listing->parent_id = 0;
			$new_listing->location_id = $request->location;
			$new_listing->user_id = $user_id;
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
			return redirect()->route('listings');
			
		}
		
    }
	
	
	public function product($id)
    {
		$user_id = Auth::id();
		$listing = Listing::find($id);
		
		if (empty($listing->id))
		{
			return back()->withErrors(['The selected brand listing do not exist']);
		}
		else
		{
			$products = Product::where('listing_id', $listing->id)->get();
		
			return view('business.products.index', ['products' => $products, 'listing' => $listing]);
		}
		
	}
	
	public function create_product($id)
	{
		$listing = Listing::find($id);
		$categories = Category::all();
		$locations = Location::all();
		
			
		if (empty($listing->id))
		{
			return back()->withErrors(['The selected brand listing do not exist']);
		}
		else
		{
			
			if ($listing->status == "SUSPENDED")
			{
				return back()->withErrors([$listing->name .' has been suspended and can not have a product.']);
			}
			elseif ($listing->status == "PENDING")
			{
				return back()->withErrors([$listing->name .' is yet to be approved and can not create a product at the moment.']);
			}
			else
			{
				$categories = Category::all();
				$locations = Location::all();

				return view('business.products.create', ['categories' => $categories, 'listing' => $listing ]);
			}
			
		}
		
	}
	
	public function add_product(Request $request, $id)
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
            'listing_id' => 'required|exists:listings,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'tips' => 'required|string',
            'price' => 'required',
            'quantity' => 'required',
             'categories.0' => 'exists:categories,id',
            'pictures.0' => 'required|mimes:jpeg,bmp,png',
            //~ 'pictures.1' => 'required|mimes:jpeg,bmp,png',
             //~ 'deliveryinfo' => 'required|string',
            'deliveryfee' => 'required',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$listing = Listing::find($request->listing_id);
			
			if ($listing->status !== "APPROVED")
			{
				return back()->withErrors(['This brand has not been approved yet']);
			}
			else
			{
				$new_product = new Product;
				$new_product->name = $request->name;
				$new_product->slug = $this->product_slug_maker($request->name);
				$new_product->description = nl2br($request->description);
				$new_product->tips = nl2br($request->tips);
				$new_product->price = $request->price;
				$new_product->quantity = $request->quantity;
				$new_product->category_id = $request->categories[0];
				$new_product->listing_id = $request->listing_id;
				$new_product->user_id = $user_id;
				$new_product->status = "PENDING";
				$new_product->save();
				
				//First Picture width 250px
				$first_picture = $request->pictures[0];
				$temp = $first_picture->store('public/temp');
				
				$file_name = explode("/", $temp);
				Storage::copy($temp,  "public/temp/thumb/".last($file_name));
				
				$image_size = Storage::size($temp);
				
				$width = 250;
				
				$img = Image::make(url(Storage::url($temp)));
				
				$img->resize($width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
				$img->save(storage_path()."/app/".$temp,100);
				
				$path = Storage::disk('do')->putFile('products',storage_path()."/app/".$temp);
				$url = Storage::disk('do')->url($path);
				Storage::delete($temp);
				
				$new_picture = new ProductPicture;
				$new_picture->product_id = $new_product->id;
				$new_picture->url = $url;
				$new_picture->save();
				
				//Second Picture width 600px
				$img = Image::make(url(Storage::url("public/temp/thumb/".last($file_name))));
				
				if ($img->width() > 600 )
				{
					$width = 600;
					$img->resize($width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
																						  
					$img->save(storage_path()."/app/public/temp/thumb/".last($file_name), 100);
					
					$path = Storage::disk('do')->putFile('products',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url = Storage::disk('do')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				else
				{
					$path = Storage::disk('do')->putFile('products',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url = Storage::disk('do')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				
				
				$new_picture = new ProductPicture;
				$new_picture->product_id = $new_product->id;
				$new_picture->url = $url;
				$new_picture->save();
						
				
				//Other Pictures
				//~ for ($i = 1; $i < 4; $i++)
				//~ {
					//~ if (!empty($request->pictures[$i]))
					//~ {
						//~ $picture = $request->pictures[$i];
						//~ $temp = $picture->store('public/temp');
						
						//~ $widths = array(250, 600);
						//~ $width = 600;
						//~ $urls = array();
						
						//~ $img = Image::make(url(Storage::url($temp)));
						
						//~ if ($img->width() > 600 )
						//~ {
							//~ $img->resize($width, null, function ($constraint) {
																									//~ $constraint->aspectRatio();
																								  //~ });
							//~ $img = Image::make(url(Storage::url($temp)))->fit(200, 350);

							//~ return $img->response('jpg');
							//~ $img->save(storage_path()."/app/".$temp);
							
							//~ $path = Storage::disk('do')->putFile('products',storage_path()."/app/".$temp);
							//~ $url = Storage::disk('do')->url($path);
							//~ Storage::delete($temp);
						//~ }
						//~ else
						//~ {
							//~ $path = Storage::disk('do')->putFile('products',storage_path()."/app/".$temp);
							//~ $url = Storage::disk('do')->url($path);
							//~ Storage::delete($temp);
						//~ }
						
						
						//~ $new_picture = new ProductPicture;
						//~ $new_picture->product_id = $new_product->id;
						//~ $new_picture->url = $url;
						//~ $new_picture->save();
						
					//~ }
					//~ else
					//~ {
						//~ $new_picture = new ProductPicture;
						//~ $new_picture->product_id = $new_product->id;
						//~ $new_picture->url = "https://via.placeholder.com/250";
						//~ $new_picture->save();
					//~ }
						
						
				//~ }
				
				//Shipment
				
				$new_shipment = new ProductShipment;
				$new_shipment->price = $request->deliveryfee;
				$new_shipment->description = $request->deliveryinfo;
				$new_shipment->return_policy = $request->returnpolicy;
				$new_shipment->product_id = $new_product->id;
				$new_shipment->save();

				session()->flash('message', 'Task was successful!');
				return redirect()->route('listings.products', ['id' => $request->listing_id]);
			}
		}
	}
	
	public function edit_product($id)
	{
		$product = Product::find($id);
		$categories = Category::all();
			
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
				$listing = Listing::find($product->listing_id);
				return view('business.products.edit', ['listing' => $listing, 'product' => $product,  'categories' => $categories ]);
			}
			
		}
	}
	
	public function update_product(Request $request)
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
			'product_id' => 'required|exists:products,id',
			'product_shipment' => 'required|exists:product_shipments,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'tips' => 'required|string',
            'price' => 'required',
            'quantity' => 'required',
             'categories.0' => 'exists:categories,id',
             //~ 'deliveryinfo' => 'required|string',
            'deliveryfee' => 'required',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_product = Product::find($request->product_id);
			$new_product->name = $request->name;
			$new_product->description = nl2br($request->description);
			$new_product->tips = nl2br($request->tips);
			$new_product->price = $request->price;
			$new_product->quantity = $request->quantity;
			$new_product->category_id = $request->categories[0];
			$new_product->user_id = $user_id;
			$new_product->status = "PENDING";
			$new_product->save();
			
			//Pictures
			if (!empty($request->pictures ))
			{
				$url = array();
				
				//First Picture width 250px
				$first_picture = $request->pictures[0];
				$temp = $first_picture->store('public/temp');
				
				$file_name = explode("/", $temp);
				Storage::copy($temp,  "public/temp/thumb/".last($file_name));
				
				$image_size = Storage::size($temp);
				
				$width = 250;
				
				$img = Image::make(url(Storage::url($temp)));
				
				$img->resize($width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
				$img->save(storage_path()."/app/".$temp,100);
				
				$path = Storage::disk('do')->putFile('products',storage_path()."/app/".$temp);
				$url[] = Storage::disk('do')->url($path);
				Storage::delete($temp);
				
				//Second Picture width 600px
				$img = Image::make(url(Storage::url("public/temp/thumb/".last($file_name))));
				
				if ($img->width() > 600 )
				{
					$width = 600;
					$img->resize($width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
																						  
					$img->save(storage_path()."/app/public/temp/thumb/".last($file_name), 100);
					
					$path = Storage::disk('do')->putFile('products',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url[] = Storage::disk('do')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				else
				{
					$path = Storage::disk('do')->putFile('products',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url[] = Storage::disk('do')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				
				$pictures = ProductPicture::where('product_id', $request->product_id)->get();
				
				$i = 0;
				foreach ($pictures as $picture)
				{
					$pic = ProductPicture::find($picture['id']);
					
					if ($i == 0 )
					{
						if (!empty($pic->id))
						{
							$remove_old = explode('/', $pic->url);
							
							Storage::disk('do')->delete('products/'.last($remove_old));
							
							$pic->url = $url[$i];
							$pic->save();
						}
					}
					else
					{
						if (!empty($pic->id))
						{
							$remove_old = explode('/', $pic->url);
							
							Storage::disk('do')->delete('products/'.last($remove_old));
							
							$pic->url = $url[$i];
							$pic->save();
						}
					}
					
					
					$i++;
				}
			
			}
			
			
			//Shipment
			
			$new_shipment = ProductShipment::find($request->product_shipment);
			$new_shipment->price = $request->deliveryfee;
			$new_shipment->description = $request->deliveryinfo;
			$new_shipment->return_policy = $request->returnpolicy;
			$new_shipment->save();
			
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('listings.products', ['id' => $new_product->listing_id ]);
			
		}
		
    }
	
	public function delete_product(Request $request)
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
			'product_id' => 'required|exists:products,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_product = Product::find($request->product_id);
			$new_product->delete();
			
			$pictures = ProductPicture::where('product_id', $request->product_id)->get();
				
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
				
			session()->flash('message', 'Task was successful!');
			return redirect()->back();
			
		}
		
    }
	
	public function slug_format($word)
	{
		$word = stripslashes($word);
		$word = strip_tags($word);
		$word = str_replace("/", "_", $word);
		$word = str_replace(" ", "_", $word);
		$word = strtolower($word);
		
		return $word;
	}
	
	public function product_slug_maker($name)
	{
		$name = $this->slug_format($name);
		$slugs = Product::where('slug', $name)->get();
		
		return $name."_".($slugs->count()+rand(1000,9000));
	}

	
}
