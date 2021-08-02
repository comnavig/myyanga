<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;

class CategoryController extends Controller
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
		$categories = Category::where('parent_id', 0)->get();
        return view('admin.category.index', ['categories' => $categories]);
    }
     
    public function subcategory($id)
    {
		$category = Category::find($id);
		
		if (empty($category->id))
		{
			return back()->withErrors(['Category does not exist']);
		}
		else
		{
			$subcategories = Category::where('parent_id', $id)->get();
			return view('admin.category.subcategory', ['category' => $category, 'subcategories' => $subcategories]);
		}
		
    }
     
	public function create()
    {
		return view('admin.category.create');
    }
    
	public function create_subcategory($id)
    {
		return view('admin.category.create-subcategory', ['cat_id' => $id]);
    }
    
    public function edit($id)
    {
		$category = Category::find($id);
		
		if (empty($category->id))
		{
			return back()->withErrors(['Category does not exist']);
		}
		else
		{
			$page_title = "Edit Category";
			$update_url = route('admin.category.update');
			return view('admin.category.edit', ['page_title' => $page_title, 'data' => $category, 'update_url' => $update_url]);
		}
		
		
    }
    
    public function edit_subcategory($id)
    {
		$subcategory = Subcategory::find($id);
		
		if (empty($subcategory->id))
		{
			return back()->withErrors(['Category does not exist']);
		}
		else
		{
			$page_title = "Edit Subcategory";
			$update_url = route('admin.subcategory.update');
			return view('admin.category.edit', ['page_title' => $page_title, 'data' => $subcategory, 'update_url' => $update_url]);
		}
		
		
    }
    
    //~ public function add(Request $request)
    //~ {
		//~ $validator = Validator::make($request->all(), [
            //~ 'name.*' => 'unique:categories,name',
        //~ ]);

        //~ if ($validator->fails()) 
        //~ {
            //~ return back()->withErrors($validator)->withInput();
        //~ }
        //~ else
		//~ {
			//~ foreach($request->name as $category)
			//~ {
				//~ if (!empty($category))
				//~ {
					//~ $new_category = new Category;
					//~ $new_category->name = $category;
					//~ $new_category->user_id = Auth::id();
					//~ $new_category->save();
				//~ }
				
			//~ }
			
			
			//~ session()->flash('message', 'Task was successful!');
			//~ return redirect()->route('admin.categories');
			
		//~ }
		
    //~ }
    
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
				$new_category = new Category;
				$new_category->name = $category;
				$new_category->parent_id = 0;
				$new_category->user_id = Auth::id();
				$new_category->save();
				
			}
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.categories');
			
		}
		
    }
    
    public function add_subcategory(Request $request)
     {
		$validator = Validator::make($request->all(), [
            'parent_id' => 'required|exists:categories,id',
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
					//~ $new_category->parent_id = $request->parent_id;
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
				$new_category = new Category;
				$new_category->name = $category;
				$new_category->parent_id = $request->parent_id;
				$new_category->user_id = Auth::id();
				$new_category->save();
				
			}
			
			session()->flash('message', 'Task was successful!');
			
			return redirect()->route('admin.category.subcategory', ['id' =>$request->parent_id]);
			
		}
		
    }
    
    
    public function update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required|exists:categories,id',
            'name' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$category = Category::find($request->id);
			$category->name = $request->name;
			$category->user_id = Auth::id();
			$category->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.categories');
		
		}
		
    }
    
    public function update_subcategory(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required|exists:categories,id',
            'name' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			
				$category = Category::find($request->id);
				$category->name = $request->name;
				$category->user_id = Auth::id();
				$category->save();
				
				session()->flash('message', 'Task was successful!');
				return redirect()->route('admin.category.subcategory', ['id' => $category->parent_id ]);
			
		}
		
    }
    
}
