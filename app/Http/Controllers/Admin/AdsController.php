<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use App\Ads;

class AdsController extends Controller
{
         /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$ads = Ads::all();
        return view('admin.ads.index', ['ads' => $ads]);
    }
    
    public function create()
    {
		return view('admin.ads.create');
    }
    
    public function edit($id)
    {
		$ad = Ads::find($id);
		return view('admin.ads.edit', ['ad' => $ad,]);
    }
    
    public function add(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'required',
            'photo_desktop' => 'required',
            'photo_mobile' => 'required',
            'expired_at' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$images = array();
			
			//Desktop
			$temp = $request->file('photo_desktop')->store('public/ads');
			//~ $image_size = Storage::size($temp);
			//~ $width = 1200;
			//~ $img = Image::make(url(Storage::url($temp)));
			//~ $img->resize($width, null, function ($constraint) {
																							//~ $constraint->aspectRatio();
																						  //~ });
			//~ $img->crop($width, 300, 0,0);
			//~ $img->save(storage_path()."/app/".$temp, 100);
			$path = Storage::disk('do')->putFile('sda',storage_path()."/app/".$temp);
			$desktop = Storage::disk('do')->url($path);
			Storage::delete($temp);
			
			$images['desktop'] = $desktop;
			
			//Moblie
			
			$temp = $request->file('photo_mobile')->store('public/ads');
			//~ $image_size = Storage::size($temp);
			//~ $width = 300;
			//~ $img = Image::make(url(Storage::url($temp)));
			//~ $img->resize($width, null, function ($constraint) {
																							//~ $constraint->aspectRatio();
																						  //~ });
			//~ $img->crop($width, 300, 0,0);
			//~ $img->save(storage_path()."/app/".$temp, 100);
			$path = Storage::disk('do')->putFile('sda',storage_path()."/app/".$temp);
			$mobile = Storage::disk('do')->url($path);
			Storage::delete($temp);
			
			$images['mobile'] = $mobile;
			
			//Add advert
			$ads = new Ads;
			$ads->name = $request->name;
			$ads->url = $request->url;
			$ads->youtube = $request->youtube;
			$ads->photo = json_encode($images);
			$ads->expired_at = $request->expired_at;
			$ads->status = "APPROVED";
			$ads->user_id = Auth::id();
			$ads->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.ads');
			
		}
		
    }
    
    public function update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'ad_id' => 'required',
            'name' => 'required',
            'url' => 'required',
            'expired_at' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$images = array();
			$ads = Ads::find($request->ad_id);
			$photo = json_decode($ads->photo, true);
			
			//Desktop
			if (!empty($request->file('photo_desktop')))
			{
				$temp = $request->file('photo_desktop')->store('public/ads');
				//~ $image_size = Storage::size($temp);
				//~ $width = 1200;
				//~ $img = Image::make(url(Storage::url($temp)));
				//~ $img->resize($width, null, function ($constraint) {
																								//~ $constraint->aspectRatio();
																							  //~ });
				//~ $img->crop($width, 300, 0,0);
				//~ $img->save(storage_path()."/app/".$temp, 100);
				$path = Storage::disk('do')->putFile('sda',storage_path()."/app/".$temp);
				$desktop = Storage::disk('do')->url($path);
				Storage::delete($temp);
				
				$images['desktop'] = $desktop;
			}
			else
			{
				
				$images['desktop'] = $photo['desktop'];
			}
			
			//Mobile
			if (!empty($request->file('photo_mobile')))
			{
				$temp = $request->file('photo_mobile')->store('public/ads');
				//~ $image_size = Storage::size($temp);
				//~ $width = 300;
				//~ $img = Image::make(url(Storage::url($temp)));
				//~ $img->resize($width, null, function ($constraint) {
																								//~ $constraint->aspectRatio();
																							  //~ });
				//~ $img->crop($width, 300, 0,0);
				//~ $img->save(storage_path()."/app/".$temp, 100);
				$path = Storage::disk('do')->putFile('sda',storage_path()."/app/".$temp);
				$mobile = Storage::disk('do')->url($path);
				Storage::delete($temp);
				
				$images['mobile'] = $mobile;
			}
			else
			{
				$images['mobile'] = $photo['mobile'];
			}
			
			
			
			$ads->name = $request->name;
			$ads->url = $request->url;
			$ads->youtube = $request->youtube;
			$ads->photo = json_encode($images);
			$ads->expired_at = $request->expired_at;
			$ads->user_id = Auth::id();
			$ads->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.ads');
			
		}
		
    }
    
    public function unapprove($id)
    {
		$ad = Ads::find($id);
		
		if (empty($ad->id))
		{
			return redirect()->route('admin.ads')->withErrors(['The requested Ad does not exist']);
		}
		else
		{
			
			$ad->status = "UNAPPROVED";
			$ad->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.ads');
		}
		
	}
    
    public function approve($id)
    {
		$ad = Ads::find($id);
		
		if (empty($ad->id))
		{
			return redirect()->route('admin.ads')->withErrors(['The requested Ad does not exist']);
		}
		else
		{
			
			$ad->status = "APPROVED";
			$ad->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.ads');
		}
		
	}
    
}
