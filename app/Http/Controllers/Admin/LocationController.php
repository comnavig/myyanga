<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Location;
use App\Area;

class LocationController extends Controller
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
		$locations = Location::where('parent_id', 0)->get();
        return view('admin.location.index', ['locations' => $locations]);
    }
    
	public function create()
    {
		return view('admin.location.create');
    }
    
    public function create_area($id)
    {
		return view('admin.location.create-areas', ['location_id' => $id]);
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
			$names = array();
			$locations = explode(",",$request->names );
			
			foreach( $locations as $location)
			{
				$check_location = Location::where('name', $location)->get();
				
				if (empty($check_location[0]['id']))
				{
					$new_location = new Location;
					$new_location->name = $location;
					$new_location->parent_id = 0;
					$new_location->user_id = Auth::id();
					$new_location->save();
				}
				else
				{
					$names[] = $location;
				}
				
			}
			
			if (empty($names))
			{
				session()->flash('message', 'Task was successful!');
			}
			else
			{
				$names_msg = implode(", ", $names);
				session()->flash('message', 'Task was successful! but the following name(s) already exists : '.$names_msg);
			}
			
			return redirect()->route('admin.locations');
			
		}
		
    }
    
	public function add_area(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'parent_id' => 'required|exists:locations,id',
			'names' => 'required',
		]);

		if ($validator->fails()) 
		{
			return back()->withErrors($validator)->withInput();
		}
		else
		{
			$names = array();
			$locations = explode(",",$request->names );
			
			foreach( $locations as $location)
			{
				$check_location = Location::where('name', $location)->get();
				
				if (empty($check_location[0]['id']))
				{
					$new_location = new Location;
					$new_location->name = $location;
					$new_location->parent_id = $request->parent_id;
					$new_location->user_id = Auth::id();
					$new_location->save();
				}
				else
				{
					$names[] = $location;
				}
				
			}
			
			if (empty($names))
			{
				session()->flash('message', 'Task was successful!');
			}
			else
			{
				$names_msg = implode(", ", $names);
				session()->flash('message', 'Task was successful! but the following name(s) already exists : '.$names_msg);
			}
			
			return redirect()->route('admin.location.areas', ['id' =>$request->parent_id]);
			
		}
		
	}

    public function area($id)
    {
		$location = Location::find($id);
		
		if (empty($location->id))
		{
			return back()->withErrors(['Location does not exist']);
		}
		else
		{
			$areas = Location::where('parent_id', $id)->get();
			return view('admin.location.areas', ['location' => $location, 'areas' => $areas]);
		}
		
    }
    
	public function edit($id)
    {
		$location = Location::find($id);
		
		if (empty($location->id))
		{
			return back()->withErrors(['Location does not exist']);
		}
		else
		{
			$page_title = "Edit Location";
			$update_url = route('admin.location.update');
			return view('admin.location.edit', ['page_title' => $page_title, 'data' => $location, 'update_url' => $update_url]);
		}
    }
    
    public function edit_area($id)
    {
		$area = Area::find($id);
		
		if (empty($area->id))
		{
			return back()->withErrors(['Location does not exist']);
		}
		else
		{
			$page_title = "Edit Area";
			$update_url = route('admin.area.update');
			return view('admin.location.edit', ['page_title' => $page_title, 'data' => $area, 'update_url' => $update_url]);
		}
		
		
    } 
    
    public function update(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required|exists:locations,id',
            'name' => 'required|unique:locations,name',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			$location = Location::find($request->id);
			$location->name = $request->name;
			$location->user_id = Auth::id();
			$location->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.locations');
		
		}
		
    }
    
	public function update_area(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'id' => 'required|exists:locations,id',
            'name' => 'required|unique:locations,name',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
        else
		{
			
				$location = Location::find($request->id);
				$location->name = $request->name;
				$location->user_id = Auth::id();
				$location->save();
				
				session()->flash('message', 'Task was successful!');
				return redirect()->route('admin.location.areas', ['id' => $location->parent_id ]);
			
		}
		
    }
    
}
