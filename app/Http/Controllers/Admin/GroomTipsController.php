<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use App\GroomTipCategory;
use App\GroomTipsPicture;
use App\GroomTips;

class GroomTipsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function index()
    {
		$user_id = Auth::id();
		
		$groomtips = GroomTips::all();
	
		return view('admin.grooming_tips.index', ['groomtips' => $groomtips]);
	}
	
	public function create()
	{
		$categories = GroomTipCategory::all();
		
		return view('admin.grooming_tips.create', ['categories' => $categories]);
			
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
            'description' => 'required|string',
             'categories.0' => 'exists:groom_tip_categories,id',
            'pictures.0' => 'required|mimes:jpeg,bmp,png',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_groomtips = new GroomTips;
			$new_groomtips->name = $request->name;
			$new_groomtips->slug = $this->groomtips_slug_maker($request->name);
			$new_groomtips->description = $request->description;
			$new_groomtips->category_id = $request->categories[0];
			$new_groomtips->user_id = $user_id;
			$new_groomtips->status = "APPROVED";
			$new_groomtips->save();
			
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
			
			$path = Storage::disk('do')->putFile('groomtips',storage_path()."/app/".$temp);
			$url = Storage::disk('do')->url($path);
			Storage::delete($temp);
			
			$new_picture = new GroomTipsPicture;
			$new_picture->groom_tips_id = $new_groomtips->id;
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
				
				$path = Storage::disk('do')->putFile('groomtips',storage_path()."/app/public/temp/thumb/".last($file_name));
				$url = Storage::disk('do')->url($path);
				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
			}
			else
			{
				$path = Storage::disk('do')->putFile('groomtips',storage_path()."/app/public/temp/thumb/".last($file_name));
				$url = Storage::disk('do')->url($path);
				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
			}
			
			
			$new_picture = new GroomTipsPicture;
			$new_picture->groom_tips_id = $new_groomtips->id;
			$new_picture->url = $url;
			$new_picture->save();
			

			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.groomingtips');
			
		}
	}
	
	public function edit($id)
	{
		$groomtips = GroomTips::find($id);
		$categories = GroomTipCategory::all();
			
		if (empty($groomtips->id))
		{
			return back()->withErrors(['The selected groomtips does not exist.']);
		}
		else
		{
			if ($groomtips->status == "SUSPENDED")
			{
				return back()->withErrors(['The selected groomtips has been suspended and can not be edited.']);
			}
			else
			{
				return view('admin.grooming_tips.edit', ['groomtips' => $groomtips,  'categories' => $categories ]);
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
			'groomtips_id' => 'required|exists:groom_tips,id',
            'name' => 'required|string',
            'description' => 'required|string',
             'categories.0' => 'exists:groom_tip_categories,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_groomtips = GroomTips::find($request->groomtips_id);
			$new_groomtips->name = $request->name;
			$new_groomtips->description = $request->description;
			$new_groomtips->category_id = $request->categories[0];
			$new_groomtips->user_id = $user_id;
			$new_groomtips->status = "APPROVED";
			$new_groomtips->save();
			
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
				
				$path = Storage::disk('do')->putFile('groomtips',storage_path()."/app/".$temp);
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
					
					$path = Storage::disk('do')->putFile('groomtips',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url[] = Storage::disk('do')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				else
				{
					$path = Storage::disk('do')->putFile('groomtips',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url[] = Storage::disk('do')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				
				$pictures = GroomTipsPicture::where('groom_tips_id', $request->groomtips_id)->get();
				
				$i = 0;
				foreach ($pictures as $picture)
				{
					$pic = GroomTipsPicture::find($picture['id']);
					
					if ($i == 0 )
					{
						if (!empty($pic->id))
						{
							$remove_old = explode('/', $pic->url);
							
							Storage::disk('do')->delete('groomtips/'.last($remove_old));
							
							$pic->url = $url[$i];
							$pic->save();
						}
					}
					else
					{
						if (!empty($pic->id))
						{
							$remove_old = explode('/', $pic->url);
							
							Storage::disk('do')->delete('groomtips/'.last($remove_old));
							
							$pic->url = $url[$i];
							$pic->save();
						}
					}
					
					
					$i++;
				}
			
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.groomingtips');
			
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
			'groomtip_id' => 'required|exists:groom_tips,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_groomtips = GroomTips::find($request->groomtip_id);
			$new_groomtips->delete();
			
			$pictures = GroomTipsPicture::where('groom_tips_id', $request->groomtip_id)->get();
				
			$i = 0;
			foreach ($pictures as $picture)
			{
				$pic = GroomTipsPicture::find($picture['id']);
				
				if (!empty($pic->id))
					{
						$remove_old = explode('/', $pic->url);
						
						Storage::disk('do')->delete('groomtips/'.last($remove_old));
						
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
	
	public function groomtips_slug_maker($name)
	{
		$name = $this->slug_format($name);
		$slugs = GroomTips::where('slug', $name)->get();
		
		return $name."_".($slugs->count()+rand(1, 9000));
	}
	
	public function categories()
    {
		$categories = GroomTipCategory::all();
        return view('admin.grooming_tips.category.index', ['categories' => $categories]);
    }
     
    public function category_create()
    {
		return view('admin.grooming_tips.category.create');
    }
    
	public function category_edit($id)
    {
		$category = GroomTipCategory::find($id);
		
		if (empty($category->id))
		{
			return back()->withErrors(['Category does not exist']);
		}
		else
		{
			$page_title = "Edit Category";
			$update_url = route('admin.groomingtip.category.update');
			return view('admin.grooming_tips.category.edit', ['page_title' => $page_title, 'data' => $category, 'update_url' => $update_url]);
		}
		
		
    }
    
    public function category_add(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'names' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			//~ $names = array();
			//~ $categories = explode(",",$request->names );
			
			//~ foreach( $categories as $category)
			//~ {
				//~ $check_category = Category::where('name', $category)->get();
				
				//~ if (empty($check_category[0]['id']))
				//~ {
					//~ $new_category = new Category;
					//~ $new_category->name = $category;
					//~ $new_category->parent_id = 0;
					//~ $new_category->user_id = Auth::id();
					//~ $new_category->save();
				//~ }
				//~ else
				//~ {
					//~ $names[] = $category;
				//~ }
				
			//~ }
			
			//~ if (empty($names))
			//~ {
				//~ session()->flash('message', 'Task was successful!');
			//~ }
			//~ else
			//~ {
				//~ $names_msg = implode(", ", $names);
				//~ session()->flash('message', 'Task was successful! but the following name(s) already exists : '.$names_msg);
			//~ }
			
			$categories = explode(",",$request->names );
			foreach( $categories as $category)
			{				
				$new_category = new GroomTipCategory;
				$new_category->name = $category;
				$new_category->user_id = Auth::id();
				$new_category->save();
				
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.groomingtip.categories');
			
		}
		
    }
    
    public function category_update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required|exists:groom_tip_categories,id',
            'name' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$category = GroomTipCategory::find($request->id);
			$category->name = $request->name;
			$category->user_id = Auth::id();
			$category->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.groomingtip.categories');
		
		}
		
    }
	
}
