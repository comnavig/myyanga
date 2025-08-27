<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Listing;
use App\Product;
use App\Address;
use App\ProductSold;
use App\ProductReview;
use App\Order;
use App\Mail\OrderPurchased;
use App\Mail\ProductPurchased;
use Illuminate\Support\Facades\Mail;
use App\Settings;
use App\User;

class ShopController extends Controller
{
    //
    
    public function __construct()
    {
		session(['cart' => array() ]);
	}
	
    public function index()
    {
        $cart = session('cart');
        $products = Product::where([['status', 'APPROVED'], ['available', '1'], ['price','>', 0]])
                            ->orderBy('id', 'desc')
                            ->paginate(12); // Change limit to paginate
    
        return view('shop.index2', [ 'cart' => $cart, 'products' => $products]);
    }
	
	public function cart()
	{
		$cart = session('cart');
		
		return view('shop.cart', ['cart' => $cart, ]);
	}
	
	public function checkout()
	{
		$user_id = Auth::id();
		$cart = session('cart');
		$addresses = Address::where('user_id', $user_id)->get();
		
		if (count($cart) == 0)
		{
			return redirect()->route('shop.cart');
		}
		else
		{
			return view('shop.checkout', ['cart' => $cart, 'addresses' => $addresses ]);
		}
		
	}
	
	public function add_to_cart(Request $request)
	{
		$messages = [
								'product_id.required' => 'No product was selected',
								'product_id.exists' => 'The selected product do not exist in the shop',
								'quantity.required' => 'Please select how many quantity of this product you need.',
								
							];
		
		$validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required',
        ], $messages);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$product = Product::find($request->product_id);
			$cart = array(
								'product' => $product, 
								'quantity' => $request->quantity, 
								'picture' => $product->picture, 
								'shipment' => $product->shipment 
								);
			
			session()->push('cart', $cart);
			session()->flash('message', 'Product has been added to cart!');
			//~ return redirect()->route('shop.cart');
			return back();
		}
	}
	
	public function remove_from_cart(Request $request)
	{
		$messages = [
								'product_id.required' => 'No product was selected',
								'product_id.exists' => 'The selected product do not exist in the shop',
								'quantity.required' => 'Please select how many quantity of this product you need.',
								
							];
		
		$validator = Validator::make($request->all(), [
            'key' => 'required',
        ], $messages);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			//~ $product = Product::find($request->product_id);
			//~ $cart = array(
								//~ 'product' => $product, 
								//~ 'quantity' => $request->quantity, 
								//~ 'picture' => $product->picture, 
								//~ 'shipment' => $product->shipment 
								//~ );
			
			session()->pull('cart.'.$request->key, '');
			session()->flash('message', 'Product has been removed ftom cart!');
			return back();
		}
	}
	
	public function product($id)
	{
		$cart = session('cart');
		$product = Product::where([['status', 'APPROVED'], ['price','>', 0], ['id',$id] ])->get();
		
// 		dd($product);
		
		if (empty($product[0]['id']))
		{
			return view('404');
		}
		else
		{
			$products_purchased = array();
			
			if (!empty(Auth::id()))
			{
				$orders = Order::where('user_id', Auth::id() )->get();
				
				foreach($orders as $order)
				{
					$data = json_decode($order->data, true);
					foreach( $data as $datum)
					{
						$products_purchased[] = $datum['product']['id']; 
					}
					
				}
			}
			
			$listing = Listing::find($product[0]['listing_id']);
			$products = Product::where([['listing_id', $listing->id ], ['status', 'APPROVED'], ['price','>', 0] ])->orderBy('id','desc')->get();
			return view('shop.product', ['cart' => $cart,'listing' => $listing, 'products' => $products, 'product' => $product->first(), 'products_purchased' => $products_purchased]);
		}
		
	}
	
	public function product_review(Request $request)
	{
		$user_id = Auth::id();
		$cart = session('cart');
		
		$messages = [
								'product_id.required' => 'No product was selected',
								'product_id.exists' => 'The selected product do not exist in the shop',
								'quantity.required' => 'Please select how many quantity of this product you need.',
								
							];
		
		$validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'review' => 'required',
        ], $messages);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			if (!empty(Auth::id()))
			{
				$orders = Order::where('user_id', Auth::id() )->get();
				
				foreach($orders as $order)
				{
					$data = json_decode($order->data, true);
					foreach( $data as $datum)
					{
						$products_purchased[] = $datum['product']['id']; 
					}
					
				}
				
				if (in_array($request->product_id, $products_purchased))
				{
					$review = new ProductReview;
					$review->review =  $request->review;
					$review->product_id =  $request->product_id;
					$review->user_id =  $user_id;
					$review->save();
				}
				
			}
			
			return back();
		}
	}
	
	public function process_payment(Request $request)
	{
		$user_id = Auth::id();
		$cart = session('cart');
		
		$messages = [
								'product_id.required' => 'No product was selected',
								'product_id.exists' => 'The selected product do not exist in the shop',
								'quantity.required' => 'Please select how many quantity of this product you need.',
								
							];
		
		$validator = Validator::make($request->all(), [
            'address' => 'required',
            'new_address' => Rule::requiredIf($request->address == "new"),
        ], $messages);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			if ($request->address == "new")
			{
				$address = new Address;
				$address->address = $request->new_address;
				$address->user_id = $user_id;
				$address->save();
				
				//Total of each item 
				$total = array();
				
				
				$order = new Order;
				$order->data = json_encode($cart);
				$order->amount = 0;
				$order->address_id = $address->id;
				$order->user_id = $user_id;
				$order->payment_details = "PENDING";
				$order->status = "PENDING";
				$order->save();
				
				foreach($cart as $item)
				{
					$total[] =  ($item['product']['price'] * $item['quantity']) + $item['shipment']['price'];
					$product_sold = new ProductSold;
					$product_sold->product_id = $item['product']['id'];
					$product_sold->quantity = $item['quantity'];
					$product_sold->amount = $item['product']['price'] * $item['quantity'];
					$product_sold->delivery = $item['shipment'];
					$product_sold->order_id = $order->id;
					$product_sold->delivery_status = "PENDING";
					$product_sold->save();
					
				}
				
				$current_order = Order::find($order->id);
				$current_order->amount  = array_sum($total);
				$current_order->save();
				
			}
			else
			{
				$address = Address::find($request->address);
				
				if (empty($address->id))
				{
					 return back()->withErrors(['The selected address do not exist on your list'])->withInput();
				}
				else
				{
				
					//Total of each item 
					$total = array();
					
					
					$order = new Order;
					$order->data = json_encode($cart);
					$order->amount = 0;
					$order->address_id = $address->id;
					$order->user_id = $user_id;
					$order->payment_details = "PENDING";
					$order->status = "PENDING";
					$order->save();
					
					foreach($cart as $item)
					{
						$total[] =  ($item['product']['price'] * $item['quantity']) + $item['shipment']['price'];
						$product_sold = new ProductSold;
						$product_sold->product_id = $item['product']['id'];
						$product_sold->quantity = $item['quantity'];
						$product_sold->amount = $item['product']['price'] * $item['quantity'];
						$product_sold->delivery = $item['shipment'];
						$product_sold->order_id = $order->id;
						$product_sold->delivery_status = "PENDING";
						$product_sold->save();
						
					}
					
					$current_order = Order::find($order->id);
					$current_order->amount  = array_sum($total);
					$current_order->save();
					
				}
			}
		
			session()->forget('cart');
			
			return redirect()->route('shop.make.payment',['id' =>$order->id]);
		}
	}
	
	public function delete_order($id)
	{
		$user_id = Auth::id();
		$user = User::find($user_id);
		$order = Order::where([ ['id',$id], ['user_id',$user_id],['status', 'PENDING'] ])->get()->first();
		
		if (empty($order->id))
		{
			return back()->withErrors(['You are not allowed to delete this pending order #'.$id]);
		}
		else
		{
			$sold_products = ProductSold::where('order_id', $order->id )->delete();
			
			$order->delete();
			
			session()->flash('message', 'Order #'.$id.' was deleted successful!');
			return back();
		}
		
	}
	
	public function make_payment($id)
	{
		$user_id = Auth::id();
		$user = User::find($user_id);
		$order = Order::find($id);
		$settings = Settings::where('name','FlutterwavePublicKey')->get();
		
		if (empty($order->id))
		{
			return back()->withErrors(['Invalid Order']);
		}
		else
		{
			$txn = $txn = time()."_".$order->id;
			return view('shop.payment', ['user' => $user, 'order' => $order, 'cart' => array(), 'items' => json_decode($order->data, true), 'settings' => $settings, 'txn' => $txn ]);
		}
		
	}
	
	public function confirm_payment(Request $request)
	{
		$messages = [
								'product_id.required' => 'No product was selected',
								'product_id.exists' => 'The selected product do not exist in the shop',
								'quantity.required' => 'Please select how many quantity of this product you need.',
								
							];
		
		$validator = Validator::make($request->all(), [
            'tx_ref' => 'required',
            'transaction_id' => 'required',
        ], $messages);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$settings = Settings::where('name','FlutterwaveSecretKey')->get();
			$txn = explode("_", $request->tx_ref);
			$order_id = last($txn);
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".$request->transaction_id."/verify",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Authorization: Bearer ".$settings[0]['value']
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$decoded_response = json_decode($response, true);
			
			if ($decoded_response['status'] == "success")
			{
				if ($decoded_response['data']['status'] == "successful")
				{
					//~ return $decoded_response['data'];
					$current_order = Order::find($order_id);
					$current_order->payment_details  = $decoded_response['data'];
					$current_order->status  = "PAID";
					$current_order->save();
					
					Mail::to($current_order->user->email)->send(new OrderPurchased($current_order));
					
					$products_sold = ProductSold::where('order_id', $current_order->id )->get();
		
					foreach($products_sold as $item)
					{
						Mail::to($item->product->user->email)->send(new ProductPurchased($item));
					}
					
					session()->flash('message', 'Payment was successful!');
					return redirect()->route('shop');
				}
				else
				{
					return redirect()->route('shop')->withErrors(["<strong>Failed</strong> Payment was not successful."]);
				}
				
			}
			else
			{
				return redirect()->route('shop')->withErrors(["<strong>Error</strong> Payment could not be verified! Verification process was not successful."]);
			}
			
		}
	}
	
}
