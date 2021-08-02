<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\DiscoverCategory;


class DiscoverCategoryController extends Controller
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
		$categories = DiscoverCategory::all();
        return view('admin.discover.category.index', ['categories' => $categories]);
    }
     
    public function create()
    {
		return view('admin.discover.category.create');
    }
    
	public function edit($id)
    {
		$category = DiscoverCategory::find($id);
		
		if (empty($category->id))
		{
			return back()->withErrors(['Category does not exist']);
		}
		else
		{
			$page_title = "Edit Category";
			$update_url = route('admin.discover.category.update');
			return view('admin.discover.category.edit', ['page_title' => $page_title, 'data' => $category, 'update_url' => $update_url]);
		}
		
		
    }
    
    public function add(Request $request)
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
				$new_category = new DiscoverCategory;
				$new_category->name = $category;
				$new_category->user_id = Auth::id();
				$new_category->save();
				
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.discover.categories');
			
		}
		
    }
    
    public function update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required|exists:discover_categories,id',
            'name' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$category = DiscoverCategory::find($request->id);
			$category->name = $request->name;
			$category->user_id = Auth::id();
			$category->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.discover.categories');
		
		}
		
    }
}
