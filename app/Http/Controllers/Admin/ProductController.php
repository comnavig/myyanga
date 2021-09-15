<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\FeaturedCategory;
use App\FeaturedProduct;
use App\ProductCategory;
use App\ProductSubcategory;
use App\ProductPicture;
use App\Product;
use App\ProductSold;
use App\DeliveryNote;
use App\Location;
use App\Order;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function index(Request $request)
    {
		$user_id = Auth::id();
		$featuredCategories = FeaturedCategory::all();
		
		if (empty($request->search))
		{
			$products = Product::orderBy('updated_at','desc')->paginate(20);
		}
		else
		{
			$products = Product::where('name', 'like', "%".$request->search."%")->orderBy('updated_at','desc')->paginate(20);
			//~ $products = Product::where([ ['name', 'like', "%".$request->search."%"], ['description', 'like', "%".$request->search."%"] ])->orderBy('id','desc')->paginate(20);
		}
		
		
		return view('admin.products.index', ['products' => $products, 'featuredCategories' => $featuredCategories]);
	}
	
    public function sold()
    {
		//~ $products = ProductSold::orderBy('created_at','desc')->paginate(20);
		$products = ProductSold::orderBy('delivery_status','desc')->paginate(20);
		
		return view('admin.products.sold', ['products' => $products, ]);
	}
	
    public function orders()
    {
		//~ $products = ProductSold::orderBy('created_at','desc')->paginate(20);
		$orders = Order::orderBy('id','desc')->paginate(20);
		
		return view('admin.products.orders', ['orders' => $orders, ]);
	}
	
    public function deliverynotes($id)
    {
		$products = ProductSold::orderBy('delivery_status','desc')->paginate(20);
		
		$deliverynotes = DeliveryNote::where('product_sold_id', $id)->paginate(20);
		
		return view('admin.products.deliverynotes', ['deliverynotes' => $deliverynotes, ]);
	}
	
	public function delivered(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'product_sold_id' => 'required|exists:product_solds,id',
            'action' => Rule::in(['delivered']),
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$action = strtoupper($request->action);
			
			$product = ProductSold::find($request->product_sold_id);
			$product->delivery_status = $action;
			$product->save();
			
			session()->flash('message', 'Task was successful!');
		}
		
		return back();
	}
	
	public function view($id)
	{
		$product = Product::find($id);
		
		if (empty($product->id))
		{
			return back()->withErrors(['the selected Product do not exist!']);
		}	
		else
		{
			return view('admin.products.view', ['product' => $product]);
		}
	}
	
	public function action(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'action' => Rule::in(['approved', 'declined','suspended']),
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$action = strtoupper($request->action);
			
			$product = Product::find($request->product_id);
			$product->status = $action;
			$product->save();
		}
		session()->flash('message', 'Task was successful!');
		
		return back();
	}
	
	
	public function delete(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$productsold = ProductSold::where("product_id",$request->product_id)->get()->first();
		
			if (empty($productsold->id))
			{
				$product = Product::find($request->product_id);
				$product->delete();
				
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
			}
			else
			{
				return back()->withErrors(['Product cannot as it have been sold']);
			}
			
		}
		session()->flash('message', 'Task was successful!');
		return back();
	}
	
	public function featured(Request $request)
	{
		$user_id = Auth::id();
		
		$validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'featuredcategory' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$product = Product::find($request->product_id);
			$product->featured = $request->featuredcategory;
			$product->save();
			
			if ($request->featuredcategory == 0)
			{
				$fp = FeaturedProduct::where('product_id',$product->id)->get();
				
				if (!empty($fp[0]['id']))
				{
					$removed_this_fp = FeaturedProduct::find($fp[0]['id']);
					$removed_this_fp->delete();
				}
				
			}
			else
			{
				$fp = FeaturedProduct::where('product_id',$product->id)->get();
				
				if (empty($fp->last()->id))
				{
					$fp = new FeaturedProduct();
					$fp->featured_category_id = $request->featuredcategory;
					$fp->product_id = $request->product_id;
					$fp->user_id = $user_id;
					$fp->save();
				}
				else
				{
					$fp = FeaturedProduct::find($fp->last()->id);
					$fp->featured_category_id = $request->featuredcategory;
					$fp->product_id = $request->product_id;
					$fp->user_id = $user_id;
					$fp->save();
					
				}
			}
		}
		
		return redirect()->route('admin.products');
	}
	
}
