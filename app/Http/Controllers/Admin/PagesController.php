<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Page;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function index()
    {
		$admin_id = Auth::id();
		$pages = Page::all();
		
		return view('admin.pages.index', ['pages' => $pages ]);
	}
	
	public function create()
	{
		$admin_id = Auth::id();
		$type = "Create";
		$locations = "";
		
		return view('admin.pages.create_edit', ['locations' => $locations, 'type' => $type ]);
	}
	
	public function edit($id)
	{
		$admin_id = Auth::id();
		$type = "Edit";
		$locations = "";
		$page = Page::find($id);
		
		if (empty($page->id))
		{
			return back()->withErrors(['Page does not exist']);
		}
		else
		{
			return view('admin.pages.create_edit', ['locations' => $locations, 'type' => $type, 'page' => $page ]);
		}
		
	}
	
	public function save(Request $request)
	{
		$admin_id = Auth::id();
		
		$messages = [
								'name.required' => 'Please type in a page title',
								'description.required' => 'Please type in your page description',
								'page_id.required' => 'Please select a valid page ID',
								'business.required' => 'Please select a valid business listing',
								'business.exists' => 'Please select a valid business listing',
								'link.url' => 'Please type in a valid URL eg. http://business.ng/page',
								'pictures.required' => 'Please upload a picture.',
							];
							

		$validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => Rule::unique('pages')->ignore($request->page_id),
            'page_id' => Rule::requiredIf($request->type == "Edit"),
            'description' => 'required|string',
        ], $messages);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			if ($request->type == "Create")
			{
				//~ $path = $request->file('picture')->store('public/pictures');
				
				$new_page = new Page;
				$new_page->name = $request->name;
				$new_page->slug = $request->slug;
				$new_page->description = $request->description;
				$new_page->user_id = $admin_id;
				//~ $new_page->status = "APPROVED";
				$new_page->save();
				
			}
			else
			{
				$page = Page::find($request->page_id);
				
				//~ if (empty($request->file('picture')))
				//~ {
					//~ $picture_url = $page->picture;
				//~ }
				//~ else
				//~ {
					//~ $path = $request->file('picture')->store('public/pictures');
					//~ $picture_url = url(Storage::url($path));
				//~ }
				
				
				
				$page->name = $request->name;
				$page->slug = $request->slug;
				$page->description = $request->description;
				$page->user_id = $admin_id;
				//~ $page->status = "APPROVED";
				$page->save();
			}
			
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.pages');
			
		}
	}

	public function delete(Request $request)
	{
		$admin_id = Auth::id();
		
		$messages = [
								'page_id.required' => 'Please select a valid page ID',
							];
							

		$validator = Validator::make($request->all(), [
            'page_id' => 'required|exists:pages,id',
		], $messages);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$page = Page::find($request->page_id);
			$page->delete();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.pages');
			
		}
	}

}
