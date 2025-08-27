<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use App\PostYourLook;
use App\UserPostYourLook;

class PYLController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function index()
    {
		$user_id = Auth::id();
		
		$pyls = PostYourLook::all();
	
		return view('admin.pyl.index', ['pyls' => $pyls]);
	}
	
    public function uploads()
    {
		$user_id = Auth::id();
		
		$uploads = UserPostYourLook::all();
	
		return view('admin.pyl.uploads', ['uploads' => $uploads]);
	}
	
	public function create()
	{
		
		return view('admin.pyl.create');
			
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
            'expired_at' => 'required',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_pyls = new PostYourLook;
			$new_pyls->name = $request->name;
			$new_pyls->slug = $this->pyls_slug_maker($request->name);
			$new_pyls->description = $request->description;
			$new_pyls->user_id = $user_id;
			$new_pyls->expired_at = $request->expired_at;
			$new_pyls->status = "APPROVED";
			$new_pyls->save();
			
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.pyls');
			
		}
	}
	
	public function edit($id)
	{
		$pyl = PostYourLook::find($id);
			
		if (empty($pyl->id))
		{
			return back()->withErrors(['The selected pyls does not exist.']);
		}
		else
		{
			if ($pyl->status == "SUSPENDED")
			{
				return back()->withErrors(['The selected pyls has been suspended and can not be edited.']);
			}
			else
			{
				return view('admin.pyl.edit', ['pyl' => $pyl,]);
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
			'pyl_id' => 'required|exists:post_your_looks,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'expired_at' => 'required',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_pyls = PostYourLook::find($request->pyl_id);
			$new_pyls->name = $request->name;
			$new_pyls->description = $request->description;
			$new_pyls->user_id = $user_id;
			$new_pyls->expired_at = $request->expired_at;
			$new_pyls->status = "APPROVED";
			$new_pyls->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.pyls');
			
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
			'pyl_id' => 'required|exists:post_your_looks,id',
        ], $messages, $customAttributes);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$new_pyls = PostYourLook::find($request->pyl_id);
			
			
			$users = UserPostYourLook::where('post_your_look_id', $request->pyl_id)->get();
				
			$i = 0;
			foreach ($users as $user)
			{
				if (!empty($user->id))
				{
					$remove_old = explode('/', $user->photo);
						
					Storage::disk('do')->delete('pyls/'.last($remove_old));
						
					$user->delete();
				}
			}
			
			$new_pyls->delete();
			
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
	
	public function pyls_slug_maker($name)
	{
		$name = $this->slug_format($name);
		$slugs = PostYourLook::where('slug', $name)->get();
		
		return $name."_".($slugs->count()+rand(1, 9000));
	}
}
