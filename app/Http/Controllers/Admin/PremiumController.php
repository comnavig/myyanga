<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use App\PremiumCategory;
use App\PremiumPicture;
use App\Premium;

class PremiumController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function index()
    {
		$user_id = Auth::id();
		
		$premia = Premium::all();
	
		return view('admin.premium.index', ['premia' => $premia]);
	}
	
	public function create()
	{
		$categories = PremiumCategory::all();
		
		return view('admin.premium.create', ['categories' => $categories]);
			
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
            'categories.0' => 'exists:premium_categories,id',
            'pictures.0' => 'required|mimes:jpeg,bmp,png',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_premia = new Premium;
			$new_premia->name = $request->name;
			//~ $new_premia->slug = $this->premia_slug_maker($request->name);
			$new_premia->description = $request->description;
			$new_premia->premium_category_id = $request->categories[0];
			$new_premia->user_id = $user_id;
			$new_premia->video_url = $request->video_url;
			$new_premia->status = "APPROVED";
			$new_premia->save();
			
			//First Picture width 250px
			$first_picture = $request->pictures[0];
			$temp = $first_picture->store('public/temp');
// 			dd(Storage::exists($temp));
			
			$file_name = explode("/", $temp);
			Storage::copy($temp,  "public/temp/thumb/".last($file_name));
			
			$image_size = Storage::size($temp);
			
			$width = 250;
			
// 			$img = Image::make(url(Storage::url($temp)));
			
// 			$img->resize($width, null, function ($constraint) {
																				// 		$constraint->aspectRatio();
																				// 	  });
// 			$img->save(storage_path()."/app/".$temp,100);
			
			$path = Storage::disk('public')->putFile('premia',storage_path()."/app/".$temp);
			$url = Storage::disk('public')->url($path);
			Storage::delete($temp);
			
			$new_picture = new PremiumPicture;
			$new_picture->premium_id = $new_premia->id;
			$new_picture->url = $url;
			$new_picture->save();
			
// 			//Second Picture width 600px
// 			$img = Image::make(url(Storage::url("public/temp/thumb/".last($file_name))));
			
// 			if ($img->width() > 600 )
// 			{
// 				$width = 600;
// 				$img->resize($width, null, function ($constraint) {
// 																						$constraint->aspectRatio();
// 																					  });
																					  
// 				$img->save(storage_path()."/app/public/temp/thumb/".last($file_name), 100);
				
// 				$path = Storage::disk('public')->putFile('premia',storage_path()."/app/public/temp/thumb/".last($file_name));
// 				$url = Storage::disk('public')->url($path);
// 				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
// 			}
// 			else
// 			{
// 				$path = Storage::disk('public')->putFile('premia',storage_path()."/app/public/temp/thumb/".last($file_name));
// 				$url = Storage::disk('public')->url($path);
// 				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
// 			}
			
			
			$new_picture = new PremiumPicture;
			$new_picture->premium_id = $new_premia->id;
			$new_picture->url = $url;
			$new_picture->save();
			

			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.premia');
			
		}
	}
	
	public function edit($id)
	{
		$premium = Premium::find($id);
		$categories = PremiumCategory::all();
			
		if (empty($premium->id))
		{
			return back()->withErrors(['The selected premia does not exist.']);
		}
		else
		{
			if ($premium->status == "SUSPENDED")
			{
				return back()->withErrors(['The selected premia has been suspended and can not be edited.']);
			}
			else
			{
				return view('admin.premium.edit', ['premium' => $premium,  'categories' => $categories ]);
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
			'premium_id' => 'required|exists:premia,id',
            'name' => 'required|string',
            'description' => 'required|string',
             'categories.0' => 'exists:premium_categories,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_premia = Premium::find($request->premium_id);
			$new_premia->name = $request->name;
			$new_premia->description = $request->description;
			$new_premia->premium_category_id = $request->categories[0];
			$new_premia->user_id = $user_id;
			$new_premia->status = "APPROVED";
			$new_premia->save();
			
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
				
				$path = Storage::disk('public')->putFile('premia',storage_path()."/app/".$temp);
				$url[] = Storage::disk('public')->url($path);
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
					
					$path = Storage::disk('public')->putFile('premia',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url[] = Storage::disk('public')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				else
				{
					$path = Storage::disk('public')->putFile('premia',storage_path()."/app/public/temp/thumb/".last($file_name));
					$url[] = Storage::disk('public')->url($path);
					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
				}
				
				$pictures = PremiumPicture::where('premium_id', $request->premium_id)->get();
				
				$i = 0;
				foreach ($pictures as $picture)
				{
					$pic = PremiumPicture::find($picture['id']);
					
					if ($i == 0 )
					{
						if (!empty($pic->id))
						{
							$remove_old = explode('/', $pic->url);
							
							Storage::disk('public')->delete('premia/'.last($remove_old));
							
							$pic->url = $url[$i];
							$pic->save();
						}
					}
					else
					{
						if (!empty($pic->id))
						{
							$remove_old = explode('/', $pic->url);
							
							Storage::disk('public')->delete('premia/'.last($remove_old));
							
							$pic->url = $url[$i];
							$pic->save();
						}
					}
					
					
					$i++;
				}
			
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.premia');
			
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
			'premium_id' => 'required|exists:premia,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_premia = Premium::find($request->premium_id);
			$new_premia->delete();
			
			$pictures = PremiumPicture::where('premium_id', $request->premium_id)->get();
				
			$i = 0;
			foreach ($pictures as $picture)
			{
				$pic = PremiumPicture::find($picture['id']);
				
				if (!empty($pic->id))
					{
						$remove_old = explode('/', $pic->url);
						
						Storage::disk('public')->delete('premia/'.last($remove_old));
						
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
	
	public function premia_slug_maker($name)
	{
		$name = $this->slug_format($name);
		$slugs = Premium::where('slug', $name)->get();
		
		return $name."_".($slugs->count()+rand(1, 9000));
	}
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function category_index()
    {
		$categories = PremiumCategory::all();
        return view('admin.premium.category.index', ['categories' => $categories]);
    }
     
    public function category_create()
    {
		return view('admin.premium.category.create');
    }
    
	public function category_edit($id)
    {
		$category = PremiumCategory::find($id);
		
		if (empty($category->id))
		{
			return back()->withErrors(['Category does not exist']);
		}
		else
		{
			$page_title = "Edit Category";
			$update_url = route('admin.premium.category.update');
			return view('admin.premium.category.edit', ['page_title' => $page_title, 'data' => $category, 'update_url' => $update_url]);
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
				$new_category = new PremiumCategory;
				$new_category->name = $category;
				$new_category->user_id = Auth::id();
				$new_category->save();
				
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.premium.categories');
			
		}
		
    }
    
    public function category_update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required|exists:premium_categories,id',
            'name' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$category = PremiumCategory::find($request->id);
			$category->name = $request->name;
			$category->user_id = Auth::id();
			$category->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.premium.categories');
		
		}
		
    }

}
