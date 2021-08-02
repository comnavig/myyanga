<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use App\DiscoverCategory;
use App\DiscoverPicture;
use App\Discover;

class DiscoverController extends Controller
{
	public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function index()
    {
		$user_id = Auth::id();
		
		$discovers = Discover::all();
	
		return view('admin.discover.index', ['discovers' => $discovers]);
	}
	
	public function create()
	{
		$categories = DiscoverCategory::all();
		
		return view('admin.discover.create', ['categories' => $categories]);
			
	}
	
	public function add(Request $request)
	{
		$user_id = Auth::id();
		
		$messages = [
								'logo.required' => 'Please upload your business logo',
								'name.required' => 'Please type in a name',
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
            'description' => 'required|string',
            'tag' => 'required|array',
            'categories.0' => 'exists:discover_categories,id',
            'pictures.0' => 'required|mimes:jpeg,bmp,png',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_discovers = new Discover;
			$new_discovers->name = $request->name;
			$new_discovers->slug = $this->discovers_slug_maker($request->name);
			$new_discovers->description = $request->description;
			$new_discovers->tag = json_encode($request->tag);
			$new_discovers->discover_category_id = $request->categories[0];
			$new_discovers->user_id = $user_id;
			$new_discovers->status = "APPROVED";
			$new_discovers->save();
			
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
			
			$path = Storage::disk('do')->putFile('discovers',storage_path()."/app/".$temp);
			$url = Storage::disk('do')->url($path);
			Storage::delete($temp);
			
			$new_picture = new DiscoverPicture;
			$new_picture->discover_id = $new_discovers->id;
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
				
				$path = Storage::disk('do')->putFile('discovers',storage_path()."/app/public/temp/thumb/".last($file_name));
				$url = Storage::disk('do')->url($path);
				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
			}
			else
			{
				$path = Storage::disk('do')->putFile('discovers',storage_path()."/app/public/temp/thumb/".last($file_name));
				$url = Storage::disk('do')->url($path);
				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
			}
			
			
			$new_picture = new DiscoverPicture;
			$new_picture->discover_id = $new_discovers->id;
			$new_picture->url = $url;
			$new_picture->save();
			

			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.discovers');
			
		}
	}
	
	public function edit($id)
	{
		$discover = Discover::find($id);
		$categories = DiscoverCategory::all();
			
		if (empty($discover->id))
		{
			return back()->withErrors(['The selected discovers does not exist.']);
		}
		else
		{
			if ($discover->status == "SUSPENDED")
			{
				return back()->withErrors(['The selected discovers has been suspended and can not be edited.']);
			}
			else
			{
				return view('admin.discover.edit', ['discover' => $discover,  'categories' => $categories ]);
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
			'discover_id' => 'required|exists:discovers,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'tag' => 'required|array',
             'categories.0' => 'exists:discover_categories,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_discovers = Discover::find($request->discover_id);
			$new_discovers->name = $request->name;
			$new_discovers->description = $request->description;
			$new_discovers->tag = json_encode($request->tag);
			$new_discovers->discover_category_id = $request->categories[0];
			$new_discovers->user_id = $user_id;
			$new_discovers->status = "APPROVED";
			$new_discovers->save();
			
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
				
				$path = Storage::disk('do')->putFile('discovers',storage_path()."/app/".$temp);
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
					
					$path = Storage::disk('do')->putFile('discovers',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url[] = Storage::disk('do')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				else
				{
					$path = Storage::disk('do')->putFile('discovers',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url[] = Storage::disk('do')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				
				$pictures = DiscoverPicture::where('discover_id', $request->discover_id)->get();
				
				$i = 0;
				foreach ($pictures as $picture)
				{
					$pic = DiscoverPicture::find($picture['id']);
					
					if ($i == 0 )
					{
						if (!empty($pic->id))
						{
							$remove_old = explode('/', $pic->url);
							
							Storage::disk('do')->delete('discovers/'.last($remove_old));
							
							$pic->url = $url[$i];
							$pic->save();
						}
					}
					else
					{
						if (!empty($pic->id))
						{
							$remove_old = explode('/', $pic->url);
							
							Storage::disk('do')->delete('discovers/'.last($remove_old));
							
							$pic->url = $url[$i];
							$pic->save();
						}
					}
					
					
					$i++;
				}
			
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.discovers');
			
		}
		
    }
	
	public function delete(Request $request)
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
			'discover_id' => 'required|exists:discovers,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_discovers = Discover::find($request->discover_id);
			$new_discovers->delete();
			
			$pictures = DiscoverPicture::where('discover_id', $request->discover_id)->get();
				
			$i = 0;
			foreach ($pictures as $picture)
			{
				$pic = DiscoverPicture::find($picture['id']);
				
				if (!empty($pic->id))
					{
						$remove_old = explode('/', $pic->url);
						
						Storage::disk('do')->delete('discovers/'.last($remove_old));
						
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
		$word = str_replace(" ", "_", $word);
		$word = strtolower($word);
		
		return $word;
	}
	
	public function discovers_slug_maker($name)
	{
		$name = $this->slug_format($name);
		$slugs = Discover::where('slug', $name)->get();
		
		return $name."_".($slugs->count()+rand(1, 9000));
	}
}
