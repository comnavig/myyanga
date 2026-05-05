<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\TvCategory;
use App\Tv;

class TVsController extends Controller
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
		$tvs = Tv::all();
        return view('admin.tv.index', ['tvs' => $tvs]);
    }
    
    public function create()
    {
		$categories = TvCategory::all();
		return view('admin.tv.create', ['categories' => $categories]);
    }
    
    public function edit($id)
    {
		$tv = Tv::find($id);
		$categories = TvCategory::all();
		
		return view('admin.tv.edit', ['tv' => $tv, 'categories' => $categories ]);
    }
    
    public function add(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'youtube' => 'required',
            'description' => 'required',
            'categories.0' => 'exists:tv_categories,id',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$photo = "https://img.youtube.com/vi/".$this->get_id($request->youtube)."/0.jpg";
			
			$tvs = new Tv;
			$tvs->name = $request->name;
			$tvs->youtube = $request->youtube;
			$tvs->tv_category_id = $request->categories[0];
			$tvs->photo = $photo;
			$tvs->description = $request->description;
			$tvs->status = "APPROVED";
			$tvs->user_id = Auth::id();
			$tvs->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.tvs');
			
		}
		
    }
    
    public function update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'tv_id' => 'required',
            'name' => 'required',
            'categories.0' => 'exists:tv_categories,id',
             'description' => 'required',
            'youtube' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$tvs = Tv::find($request->tv_id);
			
			$photo = "https://img.youtube.com/vi/".$this->get_id($request->youtube)."/0.jpg";
			
			$tvs->name = $request->name;
			$tvs->youtube = $request->youtube;
			$tvs->tv_category_id = $request->categories[0];
			$tvs->description = $request->description;
			$tvs->photo = $photo;
			$tvs->user_id = Auth::id();
			$tvs->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.tvs');
			
		}
		
    }
    
    public function unapprove($id)
    {
		$tv = Tv::find($id);
		
		if (empty($tv->id))
		{
			return redirect()->route('admin.tvs')->withErrors(['The requested Ad does not exist']);
		}
		else
		{
			
			$tv->status = "UNAPPROVED";
			$tv->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.tvs');
		}
		
	}
    
    public function approve($id)
    {
		$tv = Tv::find($id);
		
		if (empty($tv->id))
		{
			return redirect()->route('admin.tvs')->withErrors(['The requested Ad does not exist']);
		}
		else
		{
			
			$tv->status = "APPROVED";
			$tv->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.tvs');
		}
		
	}
    
    public function get_id($link)
    {
		$id = explode("=", $link);
		
		return last($id);
	}
	
	public function categories()
    {
		$categories = TvCategory::all();
        return view('admin.tv.category.index', ['categories' => $categories]);
    }
     
    public function category_create()
    {
		return view('admin.tv.category.create');
    }
    
	public function category_edit($id)
    {
		$category = TvCategory::find($id);
		
		if (empty($category->id))
		{
			return back()->withErrors(['Category does not exist']);
		}
		else
		{
			$page_title = "Edit Category";
			$update_url = route('admin.tv.category.update');
			return view('admin.tv.category.edit', ['page_title' => $page_title, 'data' => $category, 'update_url' => $update_url]);
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
				$new_category = new TvCategory;
				$new_category->name = $category;
				$new_category->user_id = Auth::id();
				$new_category->save();
				
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.tv.categories');
			
		}
		
    }
    
    public function category_update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required|exists:tv_categories,id',
            'name' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$category = TvCategory::find($request->id);
			$category->name = $request->name;
			$category->user_id = Auth::id();
			$category->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.tv.categories');
		
		}
		
    }

	public function delete(Request $request)
    {
		$user_id = Auth::id();

		$validator = Validator::make($request->all(), [
			'tv_id' => 'required|exists:tvs,id',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			
			$tv = Tv::find($request->tv_id);
			$tv->delete();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->back();
			
		}
		
    }
	
}
