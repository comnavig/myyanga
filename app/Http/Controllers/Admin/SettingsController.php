<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Settings;

class SettingsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth','only.admin']);
    }
    
    public function index()
    {
		$user_id = Auth::id();
		$raw_settings = Settings::all();
		$settings = array();
		
		foreach($raw_settings as $setting )
		{
			$settings[$setting->name] = $setting->value;
		}
		
		return view('admin.settings.index', ['settings' => $settings ]);
	}
	
	public function edit($name)
	{
		$raw_settings = Settings::where('name',$name)->get();
		$settings = $raw_settings->last();
		
		return view('admin.settings.edit', ['settings' => $settings ]);
	}
	
	public function update(Request $request)
	{
		$user_id = Auth::id();
		

		$validator = Validator::make($request->all(), [
			'settings_id' => 'exists:settings,id',
			 'value' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$settings = Settings::find($request->settings_id);
			$settings->value = $request->value;
			$settings->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.settings');
			
		}
	}

	
	public function edit_image($name)
	{
		$raw_settings = Settings::where('name',$name)->get();
		$settings = $raw_settings->last();
		
		return view('admin.settings.edit-image', ['settings' => $settings ]);
	}
	
	public function update_image(Request $request)
	{
		$user_id = Auth::id();
		

		$validator = Validator::make($request->all(), [
			'settings_id' => 'exists:settings,id',
			 'pictures.0' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }
		else
		{
			$image = $request->pictures[0]->store('settings', 'public');
			$path = Storage::disk('public')->url($image);
			
			$settings = Settings::find($request->settings_id);
			$settings->value = url($path);
			$settings->save();
			
			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.settings');
			
		}
		
	}
}
