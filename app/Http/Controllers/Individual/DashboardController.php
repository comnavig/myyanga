<?php

namespace App\Http\Controllers\Individual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserNotification;
use App\ProductFavourite;
use App\Product;
use App\Listing;
use App\Order;
use App\Category;
use App\Settings;
use App\PremiumSubscription;
use App\UserPostYourLook;
use App\ListingFollow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Mail\PremiumSubscriptionPurchased;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Premium;

class DashboardController extends Controller
{
	public $subscriptionFee;
    public $ngVAT;
    public $subscriptionDuration;
    protected $public_key;
    protected $secret_key;
        
    public function __construct()
    {
        $this->middleware(['auth','only.user','verified']);
        
        $this->subscriptionFee = Settings::where('name','premium_subscription_fee')->get()->first();
        $this->subscriptionDuration = Settings::where('name','premium_subscription_duration')->get()->first();
        $this->ngVAT = Settings::where('name','ng_vat')->get()->first();
        $this->public_key = Settings::where('name','FlutterwavePublicKey')->get()->first();
        $this->secret_key = Settings::where('name','FlutterwaveSecretKey')->get()->first();
    }
    
    public function index()
    {
		$user_id = Auth::id();
		$user = User::find($user_id);
		$activities = collect([]);
		
		foreach($user->favourites->sortDesc() as $favourite)
		{
			$activities[] = collect(['activity' => "You liked ".$favourite->product->name, "date" => $favourite->created_at ]);
		}
		
		foreach($user->follows->sortDesc() as $follow)
		{
			$activities[] = collect(['activity' => "You followed ".$follow->listing->name, "date" => $follow->created_at ]);
		}
		
		foreach($user->orders->sortDesc() as $order)
		{
			$items = json_decode($order->data, true);
			$activities[] = collect(['activity' => "You ordered for ".count($items)." products", "date" => $order->created_at ]);
		}
		
		foreach($user->pyls->sortDesc() as $pyl)
		{
			$activities[] = collect(['activity' => "You upload your photo on ".$pyl->pyl->name." competition", "date" => $pyl->created_at ]);
		}
		
		$active_subscription = PremiumSubscription::where([["user_id", "=",$user_id],["status","=","PAID"]])->orderBy('id','desc')->get()->first();
		
		return view('user.myprofile', [ 'user' => $user, 'activities' => $activities, 'active_subscription' => $active_subscription]);
	}
    
    public function activities()
    {
		$user_id = Auth::id();
		$user = User::find($user_id);
		$activities = collect([]);
		
		foreach($user->favourites->sortDesc() as $favourite)
		{
			$activities[] = collect(['activity' => "You liked ".$favourite->product->name, "date" => $favourite->created_at ]);
		}
		
		foreach($user->follows->sortDesc() as $follow)
		{
			$activities[] = collect(['activity' => "You followed ".$follow->listing->name, "date" => $follow->created_at ]);
		}
		
		foreach($user->orders->sortDesc() as $order)
		{
			$items = json_decode($order->data);
			$activities[] = collect(['activity' => "You ordered for ".count($items)." products", "date" => $order->created_at ]);
		}
		
		foreach($user->pyls->sortDesc() as $pyl)
		{
			$activities[] = collect(['activity' => "You upload your photo on ".$pyl->pyl->name." competition", "date" => $pyl->created_at ]);
		}
		
		return view('user.activities', [ 'user' => $user, 'activities' => $activities]);
	}
    
    public function edit_profile()
    {
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$notification = UserNotification::where("user_id", $user_id)->get();
		$notification = $notification->last();
		
		if (empty($notification->id))
		{
			$selected = array();
			$selected['brands'] = array();
			$selected['categories'] = array();
			$selected['days'] = array();
		}
		else
		{
			$selected = array();
			$selected['brands'] = json_decode($notification->listings,true);
			$selected['categories'] = json_decode($notification->categories,true);
			$selected['days'] = json_decode($notification->days,true);
		}
			
		
			
		$listings = Listing::all();
		$categories = Category::all();
		$days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		
		return view('user.profile-edit', [ 'user' => $user, 'listings' => $listings, 'categories' => $categories,'selected' => $selected, 'days' => $days]);
	}
	
    public function edit_notification()
    {
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$notification = UserNotification::where("user_id", $user_id)->get();
		$notification = $notification->last();
		
		if (empty($notification->id))
		{
			$selected = array();
			$selected['brands'] = array();
			$selected['categories'] = array();
			$selected['days'] = array();
		}
		else
		{
			$selected = array();
			$selected['brands'] = json_decode($notification->listings,true);
			$selected['categories'] = json_decode($notification->categories,true);
			$selected['days'] = json_decode($notification->days,true);
		}
			
		
			
		$listings = Listing::all();
		$categories = Category::all();
		$days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		
		return view('user.notification-edit', [ 'user' => $user, 'listings' => $listings, 'categories' => $categories,'selected' => $selected, 'days' => $days]);
	}
    
    public function update_profile(Request $request)
    {
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$messages = [
								'location.*.required' => 'Please select a city',
								'location.*.exists' => 'Please select a valid city',
								'type.*.required' => 'Please select a service',
								'picture.file' => 'Picture failed to upload, please try aonther',
							];
							
		$customAttributes = [
											'links' => 'email address',
										];

		$validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|string',
            //~ 'picture' => 'required|image',
            'picture' => 'file',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			
			if (!empty($request->picture) )
			{
				$temp = $request->picture->store('public/temp');
				
				//~ $file_name = explode("/", $temp);
				//~ Storage::copy($temp,  "public/temp/thumb/".last($file_name));
				
				//~ $image_size = Storage::size($temp);
				
				//~ $width = 250;
				
				//~ $img = Image::make(url(Storage::url($temp)));
				
				//~ $img->resize($width, null, function ($constraint) {
																							//~ $constraint->aspectRatio();
																						  //~ });
				//~ $img->save(storage_path()."/app/".$temp,100);
				
				$path = Storage::disk('do')->putFile('avatar',storage_path()."/app/".$temp);
				$url = Storage::disk('do')->url($path);
				Storage::delete($temp);
				$user ->avatar = $url;
				
			}
			
			$user ->name = $request->name;
			$user ->mobile = $request->mobile;
			$user->save();
			
			

			session()->flash('message', 'Task was successful!');
			
			return redirect()->route('user.profile');
			
		}
	
		
		
		
		return view('user.profile-edit', [ 'user' => $user]);
	}
	
    public function update_password(Request $request)
    {
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$messages = [
								'location.*.required' => 'Please select a city',
								'location.*.exists' => 'Please select a valid city',
								'type.*.required' => 'Please select a service',
								'picture.file' => 'Picture failed to upload, please try aonther',
							];
							
		$customAttributes = [
											'links' => 'email address',
										];

		$validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			
			$user ->password = Hash::make($request->password);
			$user->save();
			
			

			session()->flash('message', 'Task was successful!');
			
			return redirect()->route('user.profile');
			
		}
	
		
		
		
		return view('user.profile-edit', [ 'user' => $user]);
	}
	
    public function update_notification(Request $request)
    {
		$user_id = Auth::id();
		$user = User::find($user_id);

		$validator = Validator::make($request->all(), [
            'brands' => 'required|array',
            'categories' => 'required|array',
            'preferred_days' => 'required|array',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$notification = UserNotification::where("user_id", $user_id)->get();
			$notification = $notification->last();
			
			if (empty($notification->id))
			{
				$notification = new UserNotification;
				$notification->listings = json_encode($request->brands);
				$notification->categories = json_encode($request->categories);
				$notification->days = json_encode($request->preferred_days);
				$notification->user_id = $user_id;
				$notification->save();
			}
			else
			{
				$notification->listings = json_encode($request->brands);
				$notification->categories = json_encode($request->categories);
				$notification->days = json_encode($request->preferred_days);
				$notification->user_id = $user_id;
				$notification->save();
			}
			
			session()->flash('message', 'Task was successful!');
			
			return redirect()->route('user.profile');
			
		}
	
		
		
		
		return view('user.profile-edit', [ 'user' => $user]);
	}
	
	public function favourites()
	{
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$favourites = ProductFavourite::where('user_id', $user_id)->paginate(20);
		
		return view('user.favourites', [ 'user' => $user, 'favourites' => $favourites]);
	}
	
	
	public function follows()
	{
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$follows = ListingFollow::where('user_id', $user_id)->paginate(20);
		
		return view('user.follows', [ 'user' => $user, 'follows' => $follows]);
	}
	
	public function orders()
	{
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$orders = Order::where('user_id', $user_id)->paginate(20);
		
		return view('user.orders', [ 'user' => $user, 'orders' => $orders]);
	}
	
	public function order_view_item($product_id)
	{
		$product = Product::find($product_id);
		return redirect()->route('brand.product', ['slug' => $product->listing->slug, 'product_slug' => $product->slug]);
	}
	
	public function pyls(Request $request)
	{
		$user_id = Auth::id();
		$user = User::find($user_id);
		
		$pyls = UserPostYourLook::where('user_id', $user_id)->paginate(20);
		
		return view('user.pyls', [ 'user' => $user, 'pyls' => $pyls]);
	}
	
	public function pyl_upload_look(Request $request)
	{
		return "still workinging";
	}
	
	public function premium_subscriptions()
	{
		$user_id = Auth::id();
		$subscriptions = PremiumSubscription::where("user_id",$user_id)->orderBy('id','desc')->get();
		$active_subscription = PremiumSubscription::where([["user_id", "=",$user_id],["status","=","PAID"]])->orderBy('id','desc')->get()->first();
		$premiums = Premium::orderBy('id', 'desc')->get();
		
		return view('user.premium.subscriptions', ["subscriptions"=> $subscriptions, 'active_subscription' => $active_subscription, 'subscribtion_duration' => $this->subscriptionDuration, 'premia' => $premiums] );
	}
	
	public function premium_subscriptions_calculation(Request $request)
	{
		$user = Auth::user();
		$user_id = Auth::id();
		
		$validator = Validator::make($request->all(), [
           'package' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$track_id = rand(100000000, 900000000).$user_id;
			$subscriptions = PremiumSubscription::where([["user_id", "=",$user_id],["status","=","PAID"]])->orderBy('id','desc')->get()->first();
			
			//~ return $subscriptions;
			
			if (empty($subscriptions))
			{
				$package = $this->subscriptionDuration->value * $request->package;
				$transactionDate = date_create("now");
				//~ $expiry = mktime(0,0,0,date('n'), date('j'), date('Y'));
				$expiry = $this->subscriptionExpiryDate($package, date_create("now"));
				$amount = $this->subscriptionFee->value * $request->package;
				$vat = $amount * $this->ngVAT->value;
				$total = round($amount + $vat);
				
				$subs = new PremiumSubscription;
				$subs->user_id = $user_id;
				$subs->expiry = $expiry;
				$subs->amount = $amount;
				$subs->vat = $vat;
				$subs->trans_data = "PENDING";
				$subs->track_id = $track_id;
				$subs->status = "PENDING";
				$subs->save();
				
			}
			else
			{
				
				if ($this->subscriptionDaysOver($subscriptions->expiry))
				{
					$package = $this->subscriptionDuration->value * $request->package;
					$transactionDate = date_create("now");
					//~ $expiry = mktime(0,0,0,date('n'), date('j'), date('Y'));
					$expiry = $this->subscriptionExpiryDate($package, date_create("now"));
					$amount = $this->subscriptionFee->value * $request->package;
					$vat = $amount * $this->ngVAT->value;
					$total = round($amount + $vat);
					
					$subs = new PremiumSubscription;
					$subs->user_id = $user_id;
					$subs->expiry = $expiry;
					$subs->amount = $amount;
					$subs->vat = $vat;
					$subs->trans_data = "PENDING";
					$subs->track_id = $track_id;
					$subs->status = "PENDING";
					$subs->save();
				}
				else
				{
					$package = $this->subscriptionDuration->value * $request->package;
					$transactionDate = date_create("now");
					//~ $expiry = mktime(0,0,0,date('n'), date('j'), date('Y'));
					$expiry = $this->subscriptionExpiryDate($package, date_create($subscriptions->expiry));
					$amount = $this->subscriptionFee->value * $request->package;
					$vat = $amount * $this->ngVAT->value;
					$total = $amount + $vat;
					
					$subs = new PremiumSubscription;
					$subs->user_id = $user_id;
					$subs->expiry = $expiry;
					$subs->amount = $amount;
					$subs->vat = $vat;
					$subs->trans_data = "PENDING";
					$subs->track_id = $track_id;
					$subs->status = "PENDING";
					$subs->save();
				}
			}
			
		}
		
		return view('user.premium.subscriptions-form',['user' => $user, 'public_key' => $this->public_key, 'track_id' => $track_id, 'package' => $package, 'transactionDate' => $transactionDate, 'expiry' => $expiry,'amount'=> $amount, 'vat' => $vat, 'total' => $total ]);
	}
	
	public function premium_subscriptions_confirm_payment(Request $request)
	{
		$user = Auth::user();
		$user_id = Auth::id();
		
		$validator = Validator::make($request->all(), [
            'tx_ref' => 'required',
            'transaction_id' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$txn = $request->tx_ref;
			
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
				"Authorization: Bearer ".$this->secret_key->value
			  ),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$decoded_response = json_decode($response, true);
			
			if ($decoded_response['status'] == "success")
			{
				if ($decoded_response['data']['status'] == "successful")
				{
					$result = json_encode($decoded_response);
					$r = $this->subscriptionStatusUpdate("PAID", $result, $request->tx_ref);
					
					$ps = PremiumSubscription::where("track_id", $request->tx_ref)->get()->first();
					
					Mail::to($ps->user->email)->send(new PremiumSubscriptionPurchased($ps));
					
					//~ session()->flash('message', 'Payment was successful!');
					//~ return redirect()->route('user.premium.subscriptions');
				}
				else
				{
					//~ return redirect()->route('user.premium.subscriptions')->withErrors(["<strong>Failed</strong> Payment was not successful."]);
					$result = json_encode($decoded_response);
					$r = $this->subscriptionStatusUpdate("FAILED", $result, $request->tx_ref);
				}
				
			}
			else
			{
				//~ return redirect()->route('user.premium.subscriptions')->withErrors(["<strong>Error</strong> Payment could not be verified! Verification process was not successful."]);
				$result = json_encode($decoded_response);
				$r = $this->subscriptionStatusUpdate("FAILED", $result, $request->tx_ref);
			}
			
			$subscription = PremiumSubscription::where("track_id",$request->tx_ref)->get()->first();
			
			return view('user.premium.subscription-result', ['subscription' => $subscription]);
			
			
		}
	
	}
	
	public function subscriptionExpiryDate($days, $date /*Date from date_create*/)
	{
		$newDate = $date;
		date_add($newDate, date_interval_create_from_date_string($days.' days'));
		return $newDate;
	}
	
	public function subscriptionStatusUpdate($status, $data, $track_id)
	{
		$subs = PremiumSubscription::where("track_id", $track_id)->get();
		
		if (empty($subs[0]['id']))
		{
			return false;
		}
		else
		{
			$subscription = PremiumSubscription::find($subs[0]['id']);
			$subscription->trans_data = $data;
			$subscription->status = $status;
			$subscription->save();
			
			return true;
		}
		
		
	}
	
	public function subscriptionDaysOver($expiry)
	{
		$date1=date_create("now");
		$date2=date_create($expiry);
		
		if($date1 > $date2)
		{
			return true;
		}
		
		return false;
	}
	
}
