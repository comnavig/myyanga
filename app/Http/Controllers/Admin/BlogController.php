<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use App\PostCategory;
use App\PostPicture;
use App\Post;

class BlogController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function post()
    {
		$user_id = Auth::id();
		
		$posts = Post::all();
	
		return view('admin.post.index', ['posts' => $posts]);
	}
	
	public function create_post()
	{
		$categories = PostCategory::all();
		
		return view('admin.post.create', ['categories' => $categories]);
			
	}
	
	public function add_post(Request $request)
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
             'categories.0' => 'exists:post_categories,id',
            'pictures.0' => 'required|mimes:jpeg,bmp,png',
            'status' => 'required|in:APPROVED,DRAFT',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_post = new Post;
			$new_post->name = $request->name;
			$new_post->slug = $this->post_slug_maker($request->name);
			$new_post->description = $request->description;
			$new_post->post_category_id = $request->categories[0];
			$new_post->user_id = $user_id;
			$new_post->status = $request->status;
			$new_post->save();
			
			//First Picture width 250px
			
			$first_picture = $request->pictures[0];
            $path = $first_picture->store('posts', 'public');
            $url = \App\Helpers\StorageHelper::getUrl('public', $path);
            
            $new_picture = new PostPicture;
            $new_picture->post_id = $new_post->id;
            $new_picture->url = $url;
            $new_picture->save();

			
			
// 			$first_picture = $request->pictures[0];
// 			$path = $first_picture->store('/posts', ['disk' => 'posts']);
//             $url = url(Storage::url($path));
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
			
// 			$path = Storage::disk('public')->putFile('posts',storage_path()."/app/".$temp);
// 			$url = \App\Helpers\StorageHelper::getUrl('public', $path);
// 			Storage::delete($temp);
			
// 			$new_picture = new PostPicture;
// 			$new_picture->post_id = $new_post->id;
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
				
// 				$path = Storage::disk('public')->putFile('posts',storage_path()."/app/public/temp/thumb/".last($file_name));
// 				$url = \App\Helpers\StorageHelper::getUrl('public', $path);
// 				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
// 			}
// 			else
// 			{
// 				$path = Storage::disk('public')->putFile('posts',storage_path()."/app/public/temp/thumb/".last($file_name));
// 				$url = \App\Helpers\StorageHelper::getUrl('public', $path);
// 				Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
// 			}
			
			
// 			$new_picture = new PostPicture;
// 			$new_picture->post_id = $new_post->id;
// 			$new_picture->url = $url;
// 			$new_picture->save();
			

			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.blog.posts');
			
		}
	}
	
	public function edit_post($id)
	{
		$post = Post::find($id);
		$categories = PostCategory::all();
			
		if (empty($post->id))
		{
			return back()->withErrors(['The selected post does not exist.']);
		}
		else
		{
			if ($post->status == "SUSPENDED")
			{
				return back()->withErrors(['The selected post has been suspended and can not be edited.']);
			}
			else
			{
				return view('admin.post.edit', ['post' => $post,  'categories' => $categories ]);
			}
			
		}
	}
	
	public function update_post(Request $request)
    {
        // dd(storage_path('app/public'), public_path('storage/posts'));
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
			'post_id' => 'required|exists:posts,id',
            'name' => 'required|string',
            'description' => 'required|string',
             'categories.0' => 'exists:post_categories,id',
             'status' => 'required|in:APPROVED,DRAFT',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_post = Post::find($request->post_id);
			$new_post->name = $request->name;
			$new_post->description = $request->description;
			$new_post->post_category_id = $request->categories[0];
			$new_post->user_id = $user_id;
			$new_post->status = $request->status;
			$new_post->save();
			
			//Pictures
// 			if (!empty($request->pictures ))
// 			{
// 				$url = array();
				
// 				//First Picture width 250px
// 				$first_picture = $request->pictures[0];
// 				$temp = $first_picture->store('public/temp');
				
// 				$file_name = explode("/", $temp);
// 				Storage::copy($temp,  "public/temp/thumb/".last($file_name));
				
// 				$image_size = Storage::size($temp);
				
// 				$width = 250;
				
// 				$img = Image::make(url(Storage::url($temp)));
				
// 				$img->resize($width, null, function ($constraint) {
// 																							$constraint->aspectRatio();
// 																						  });
// 				$img->save(storage_path()."/app/".$temp,100);
				
// 				$path = Storage::disk('public')->putFile('posts',storage_path()."/app/".$temp);
// 				$url[] = \App\Helpers\StorageHelper::getUrl('public', $path);
// 				Storage::delete($temp);
				
// 				//Second Picture width 600px
// 				$img = Image::make(url(Storage::url("public/temp/thumb/".last($file_name))));
				
// 				if ($img->width() > 600 )
// 				{
// 					$width = 600;
// 					$img->resize($width, null, function ($constraint) {
// 																							$constraint->aspectRatio();
// 																						  });
																						  
// 					$img->save(storage_path()."/app/public/temp/thumb/".last($file_name), 100);
					
// 					$path = Storage::disk('public')->putFile('posts',storage_path()."/app/public/temp/thumb/".last($file_name));
// 					$url[] = \App\Helpers\StorageHelper::getUrl('public', $path);
// 					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
// 				}
// 				else
// 				{
// 					$path = Storage::disk('public')->putFile('posts',storage_path()."/app/public/temp/thumb/".last($file_name));
// 					$url[] = \App\Helpers\StorageHelper::getUrl('public', $path);
// 					Storage::delete(storage_path()."/app/public/temp/thumb/".last($file_name));
// 				}
				
// 				$pictures = PostPicture::where('post_id', $request->post_id)->get();
				
// 				$i = 0;
// 				foreach ($pictures as $picture)
// 				{
// 					$pic = PostPicture::find($picture['id']);
					
// 					if ($i == 0 )
// 					{
// 						if (!empty($pic->id))
// 						{
// 							$remove_old = explode('/', $pic->url);
							
// 							Storage::disk('public')->delete('posts/'.last($remove_old));
							
// 							$pic->url = $url[$i];
// 							$pic->save();
// 						}
// 					}
// 					else
// 					{
// 						if (!empty($pic->id))
// 						{
// 							$remove_old = explode('/', $pic->url);
							
// 							Storage::disk('public')->delete('posts/'.last($remove_old));
							
// 							$pic->url = $url[$i];
// 							$pic->save();
// 						}
// 					}
					
					
// 					$i++;
// 				}
			
// 			}

            if ($request->hasFile('pictures')) {
                $pictures = $request->file('pictures');
                $url = [];
    
                foreach ($pictures as $index => $picture) {
                    $path = $picture->store('posts', 'public');
                    $url[] = \App\Helpers\StorageHelper::getUrl('public', $path);


    
                    // Save picture record in database
                    $postPicture = new PostPicture();
                    $postPicture->post_id = $request->post_id;
                    $postPicture->url = $url[$index];
                    $postPicture->save();
                }
            }
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.blog.posts');
			
		}
		
    }
	
	public function delete_post(Request $request)
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
			'post_id' => 'required|exists:posts,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_post = Post::find($request->post_id);
			$new_post->delete();
			
			$pictures = PostPicture::where('post_id', $request->post_id)->get();
				
			$i = 0;
			foreach ($pictures as $picture)
			{
				$pic = PostPicture::find($picture['id']);
				
				if (!empty($pic->id))
					{
						$remove_old = explode('/', $pic->url);
						
						Storage::disk('public')->delete('posts/'.last($remove_old));
						
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
		$word = str_replace("/", "_", $word);
		$word = str_replace("?", "_", $word);
		$word = strtolower($word);
		
		return $word;
	}
	
	public function post_slug_maker($name)
	{
		$name = $this->slug_format($name);
		$slugs = Post::where('slug', $name)->get();
		
		return $name."_".($slugs->count()+rand(1, 9000));
	}

}
