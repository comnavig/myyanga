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
		
// 		dd($discovers[0]->picture[0]->url);
		
// 		dd($discovers);
	
		return view('admin.discover.index', ['discovers' => $discovers]);
	}
	
	public function create()
	{
		$categories = DiscoverCategory::all();
		
		return view('admin.discover.create', ['categories' => $categories]);
			
	}
	
// 	public function add(Request $request)
// 	{
// 		$user_id = Auth::id();
		
// 		$messages = [
// 								'logo.required' => 'Please upload your business logo',
// 								'name.required' => 'Please type in a name',
// 								'cac.required' => 'Please indicate if your business is registered with CAC',
// 								'cac_no.required' => 'Please type in your CAC Registration Number',
// 								'description.required' => 'Please type in your business description',
// 								'location.required' => 'Please select a city',
// 								'location.exists' => 'Please select a valid city',
// 								'categories.*.required' => 'Please select a category',
// 								'categories.*.exists' => 'Please select a valid category',
// 								'links.*.required' => 'Please type in your business url.',
// 								'links.*.url' => 'Please type in a valid URL eg. http://business.ng',
// 								'pictures.*.required' => 'Please upload atleast a picture.',
// 								'emails.*.required' => 'Please type in your business email address.',
// 								'phones.*.required' => 'Please type in your business phone.',
// 								'phones.*.digits' => 'Please your business phone must be 11 digits.',
// 							];
							
// 		$customAttributes = [
// 											'links' => 'email address',
// 										];

// 		$validator = Validator::make($request->all(), [
//             'name' => 'required|string',
//             'description' => 'required|string',
//             'tag' => 'required|array',
//             'categories.0' => 'exists:discover_categories,id',
//             'pictures.0' => 'required|mimes:jpeg,bmp,png',
//         ], $messages, $customAttributes);

//         if ($validator->fails()) 
//         {
//             return back()->withErrors($validator)->withInput();
//         }
// 		else
// 		{
			
// 			$new_discovers = new Discover;
// 			$new_discovers->name = $request->name;
// 			$new_discovers->slug = $this->discovers_slug_maker($request->name);
// 			$new_discovers->description = $request->description;
// 			$new_discovers->tag = json_encode($request->tag);
// 			$new_discovers->discover_category_id = $request->categories[0];
// 			$new_discovers->user_id = $user_id;
// 			$new_discovers->status = "APPROVED";
// 			$new_discovers->save();
			
// 			//First Picture width 250px
// 			$first_picture = $request->pictures[0];
// 			$temp = $first_picture->store('public/temp');
			
// 			$file_name = explode("/", $temp);
// 			Storage::copy($temp,  "public/temp/thumb/".last($file_name));
			
// 			$image_size = Storage::size($temp);
			
// 			$width = 250;
			
// 			$img = Image::make(url(Storage::url($temp)));
			
// 			$img->resize($width, null, function ($constraint) {
// 																						$constraint->aspectRatio();
// 																					  });
// 			$img->save(storage_path()."/app/".$temp,100);
			
// 			$path = Storage::disk('public')->putFile('discovers',storage_path()."/app/".$temp);
// 			$url = Storage::disk('public')->url($path);
// 			Storage::delete($temp);
			
// 			$new_picture = new DiscoverPicture;
// 			$new_picture->discover_id = $new_discovers->id;
// 			$new_picture->url = $url;
// 			$new_picture->save();
			
// 			//Second Picture width 600px
// 			$img = Image::make(url(Storage::url("public/temp/thumb/".last($file_name))));
			
// 			if ($img->width() > 600 )
// 			{
// 				$width = 600;
// 				$img->resize($width, null, function ($constraint) {
// 																						$constraint->aspectRatio();
// 																					  });
																					  
// 				$img->save(storage_path()."/app/public/temp/thumb/".last($file_name), 100);
				
// 				$path = Storage::disk('public')->putFile('discovers',storage_path()."/app/public/temp/thumb/".last($file_name));
// 				$url = Storage::disk('public')->url($path);
// 				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
// 			}
// 			else
// 			{
// 				$path = Storage::disk('public')->putFile('discovers',storage_path()."/app/public/temp/thumb/".last($file_name));
// 				$url = Storage::disk('public')->url($path);
// 				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
// 			}
			
			
// 			$new_picture = new DiscoverPicture;
// 			$new_picture->discover_id = $new_discovers->id;
// 			$new_picture->url = $url;
// 			$new_picture->save();
			

// 			session()->flash('message', 'Task was successful!');
// 			return redirect()->route('admin.discovers');
			
// 		}
// 	}
	
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
        'pictures.*.required' => 'Please upload at least a picture.',
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
        $first_picture = $request->file('pictures')[0];
        $temp = $first_picture->store('public/temp');
        
        $file_name = last(explode("/", $temp));
        $temp_path = storage_path('app/' . $temp);
        $thumb_path = storage_path('app/public/temp/thumb/' . $file_name);
        
        Storage::copy($temp, 'public/temp/thumb/' . $file_name);
        
        try {
            $img = Image::make($temp_path);
            $img->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($temp_path, 100);
        } catch (\Exception $e) {
            return back()->withErrors(['image_error' => 'Unable to process the image from the given URL.'])->withInput();
        }
        
        $path = Storage::disk('public')->putFile('discovers', $temp_path);
        $url = Storage::disk('public')->url($path);
        Storage::delete($temp);
        
        $new_picture = new DiscoverPicture;
        $new_picture->discover_id = $new_discovers->id;
        $new_picture->url = $url;
        $new_picture->save();
        
        //Second Picture width 600px
        $img = Image::make($thumb_path);
        
        if ($img->width() > 600) {
            $img->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumb_path, 100);
        }
        
        $path = Storage::disk('public')->putFile('discovers', $thumb_path);
        $url = Storage::disk('public')->url($path);
        Storage::delete($thumb_path);
        
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
	
// 	public function update(Request $request)
// {
//     $user_id = Auth::id();

//     $messages = [
//         'logo.required' => 'Please upload your business logo',
//         'name.required' => 'Please type in your business name',
//         'cac.required' => 'Please indicate if your business is registered with CAC',
//         'cac_no.required' => 'Please type in your CAC Registration Number',
//         'description.required' => 'Please type in your business description',
//         'location.required' => 'Please select a city',
//         'location.exists' => 'Please select a valid city',
//         'categories.*.required' => 'Please select a category',
//         'categories.*.exists' => 'Please select a valid category',
//         'links.*.required' => 'Please type in your business url.',
//         'links.*.url' => 'Please type in a valid URL eg. http://business.ng',
//         'pictures.*.required' => 'Please upload atleast a picture.',
//         'emails.*.required' => 'Please type in your business email address.',
//         'phones.*.required' => 'Please type in your business phone.',
//         'phones.*.digits' => 'Please your business phone must be 11 digits.',
//     ];

//     $customAttributes = [
//         'links' => 'email address',
//     ];

//     $validator = Validator::make($request->all(), [
//         'discover_id' => 'required|exists:discovers,id',
//         'name' => 'required|string',
//         'description' => 'required|string',
//         'tag' => 'required|array',
//         'categories.0' => 'exists:discover_categories,id',
//     ], $messages, $customAttributes);

//     if ($validator->fails()) {
//         return back()->withErrors($validator)->withInput();
//     } else {
//         $new_discovers = Discover::find($request->discover_id);
//         $new_discovers->name = $request->name;
//         $new_discovers->description = $request->description;
//         $new_discovers->tag = json_encode($request->tag);
//         $new_discovers->discover_category_id = $request->categories[0];
//         $new_discovers->user_id = $user_id;
//         $new_discovers->status = "APPROVED";
//         $new_discovers->save();

//         // Pictures
//         if (!empty($request->pictures)) {
//             $url = array();

//             // First Picture width 250px
//             $first_picture = $request->file('pictures')[0];
//             $temp = $first_picture->store('public/temp');

//             $file_name = explode("/", $temp);
//             Storage::copy($temp, "public/temp/thumb/" . last($file_name));

//             $image_size = Storage::size($temp);
//             $width = 250;

//             try {
//                 $temp_url = Storage::url($temp);
//                 // Log::info("Attempting to load image from URL: $temp_url");
//                 $img = Image::make(storage_path('app/' . $temp));
//                 $img->resize($width, null, function ($constraint) {
//                     $constraint->aspectRatio();
//                 });
//                 $img->save(storage_path('app/' . $temp), 100);

//                 $path = Storage::disk('public')->putFile('discovers', storage_path('app/' . $temp));
//                 $url[] = Storage::disk('public')->url($path);
//                 Storage::delete($temp);
//             } catch (\Exception $e) {
//                 // Log::error("Error processing image: " . $e->getMessage());
//                 return back()->withErrors(['image_error' => 'Unable to process the image from the given URL.'])->withInput();
//             }

//             // Second Picture width 600px
//             try {
//                 $thumb_url = Storage::url("public/temp/thumb/" . last($file_name));
//                 // Log::info("Attempting to load image from URL: $thumb_url");
//                 $img = Image::make(storage_path('app/public/temp/thumb/' . last($file_name)));

//                 if ($img->width() > 600) {
//                     $width = 600;
//                     $img->resize($width, null, function ($constraint) {
//                         $constraint->aspectRatio();
//                     });

//                     $img->save(storage_path('app/public/temp/thumb/' . last($file_name)), 100);

//                     $path = Storage::disk('public')->putFile('discovers', storage_path('app/public/temp/thumb/' . last($file_name)));
//                     $url[] = Storage::disk('public')->url($path);
//                     Storage::delete(storage_path('app/public/temp/thumb/' . last($file_name)));
//                 } else {
//                     $path = Storage::disk('public')->putFile('discovers', storage_path('app/public/temp/thumb/' . last($file_name)));
//                     $url[] = Storage::disk('public')->url($path);
//                     Storage::delete(storage_path('app/public/temp/thumb/' . last($file_name)));
//                 }
//             } catch (\Exception $e) {
//                 // Log::error("Error processing second image: " . $e->getMessage());
//                 return back()->withErrors(['image_error' => 'Unable to process the second image from the given URL.'])->withInput();
//             }

//             $pictures = DiscoverPicture::where('discover_id', $request->discover_id)->get();

//             $i = 0;
//             foreach ($pictures as $picture) {
//                 $pic = DiscoverPicture::find($picture['id']);

//                 if ($i == 0) {
//                     if (!empty($pic->id)) {
//                         $remove_old = explode('/', $pic->url);
//                         Storage::disk('public')->delete('discovers/' . last($remove_old));
//                         $pic->url = $url[$i];
//                         $pic->save();
//                     }
//                 } else {
//                     if (!empty($pic->id)) {
//                         $remove_old = explode('/', $pic->url);
//                         Storage::disk('public')->delete('discovers/' . last($remove_old));
//                         $pic->url = $url[$i];
//                         $pic->save();
//                     }
//                 }

//                 $i++;
//             }
//         }

//         session()->flash('message', 'Task was successful!');
//         return redirect()->route('admin.discovers');
//     }
// }

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
        'pictures.*.required' => 'Please upload at least a picture.',
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

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    } else {
        $discover = Discover::find($request->discover_id);
        $discover->name = $request->name;
        $discover->description = $request->description;
        $discover->tag = json_encode($request->tag);
        $discover->discover_category_id = $request->categories[0];
        $discover->user_id = $user_id;
        $discover->status = "APPROVED";
        $discover->save();

        // Delete existing images
        $existingPictures = DiscoverPicture::where('discover_id', $request->discover_id)->get();
        foreach ($existingPictures as $existingPicture) {
            $path = str_replace("/storage/", "public/", $existingPicture->url);
            Storage::delete($path);
            $existingPicture->delete();
        }

        // Upload and save new pictures
        if (!empty($request->pictures)) {
            $urls = [];

            foreach ($request->pictures as $index => $picture) {
                // Save picture to temp
                $tempPath = $picture->store('public/temp');
                $fileName = last(explode("/", $tempPath));

                // Create thumbnail
                Storage::copy($tempPath, "public/temp/thumb/" . $fileName);

                // Resize and save the image
                $img = Image::make(storage_path('app/' . $tempPath));
                $img->resize(250, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(storage_path('app/' . $tempPath), 100);

                // Move to final destination
                $finalPath = Storage::disk('public')->putFile('discovers', storage_path('app/' . $tempPath));
                $url = Storage::disk('public')->url($finalPath);
                Storage::delete($tempPath);

                // Save to database
                $newPicture = new DiscoverPicture();
                $newPicture->discover_id = $discover->id;
                $newPicture->url = $url;
                $newPicture->save();

                // Handle larger thumbnail if needed
                $thumbPath = storage_path('app/public/temp/thumb/' . $fileName);
                $img = Image::make($thumbPath);
                if ($img->width() > 600) {
                    $img->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbPath, 100);
                }

                $finalThumbPath = Storage::disk('public')->putFile('discovers', $thumbPath);
                $thumbUrl = Storage::disk('public')->url($finalThumbPath);
                Storage::delete($thumbPath);

                // Save thumbnail to database
                $newThumbPicture = new DiscoverPicture();
                $newThumbPicture->discover_id = $discover->id;
                $newThumbPicture->url = $thumbUrl;
                $newThumbPicture->save();
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
						
						Storage::disk('public')->delete('discovers/'.last($remove_old));
						
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
