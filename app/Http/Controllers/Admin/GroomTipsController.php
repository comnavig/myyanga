<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use App\GroomTipCategory;
use App\GroomTipsPicture;
use App\GroomTips;

class GroomTipsController extends Controller
{
	//
	public function __construct()
	{
		$this->middleware(['auth', 'only.admin']);
	}

	public function index()
	{
		$user_id = Auth::id();

		$groomtips = GroomTips::all();

		return view('admin.grooming_tips.index', ['groomtips' => $groomtips]);
	}

	public function create()
	{
		$categories = GroomTipCategory::all();

		return view('admin.grooming_tips.create', ['categories' => $categories]);
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
			'categories.0' => 'exists:groom_tip_categories,id',
			'pictures.0' => 'required|mimes:jpeg,bmp,png',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {

			$new_groomtips = new GroomTips;
			$new_groomtips->name = $request->name;
			$new_groomtips->slug = $this->groomtips_slug_maker($request->name);
			$new_groomtips->description = $request->description;
			$new_groomtips->category_id = $request->categories[0];
			$new_groomtips->user_id = $user_id;
			$new_groomtips->status = "APPROVED";
			$new_groomtips->save();

			//First Picture width 250px
			$first_picture = $request->pictures[0];
			$filename = time() . '_' . uniqid() . '.' . $first_picture->getClientOriginalExtension();

			// Load and resize to 250px
			$img = Image::make($first_picture);
			$img->resize(250, null, function ($constraint) {
				$constraint->aspectRatio();
			});

			// Save to public/storage/groomtips folder
			$small_path = 'groomtips/small_' . $filename;
			$img->save(public_path('storage/' . $small_path), 100);

			// Get URL for the small image
			$small_url = '/storage/' . $small_path;

			$new_picture = new GroomTipsPicture;
			$new_picture->groom_tips_id = $new_groomtips->id;
			$new_picture->url = $small_url;
			$new_picture->save();

			//Second Picture width 600px
			$img = Image::make($first_picture);

			if ($img->width() > 600) {
				$img->resize(600, null, function ($constraint) {
					$constraint->aspectRatio();
				});
			}

			// Save to public/storage/groomtips folder
			$medium_path = 'groomtips/medium_' . $filename;
			$img->save(public_path('storage/' . $medium_path), 100);

			// Get URL for the medium image
			$medium_url = '/storage/' . $medium_path;

			$new_picture = new GroomTipsPicture;
			$new_picture->groom_tips_id = $new_groomtips->id;
			$new_picture->url = $medium_url;
			$new_picture->save();


			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.groomingtips');
		}
	}

	public function edit($id)
	{
		$groomtips = GroomTips::find($id);
		$categories = GroomTipCategory::all();

		if (empty($groomtips->id)) {
			return back()->withErrors(['The selected groomtips does not exist.']);
		} else {
			if ($groomtips->status == "SUSPENDED") {
				return back()->withErrors(['The selected groomtips has been suspended and can not be edited.']);
			} else {
				return view('admin.grooming_tips.edit', ['groomtips' => $groomtips,  'categories' => $categories]);
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
			'groomtips_id' => 'required|exists:groom_tips,id',
			'name' => 'required|string',
			'description' => 'required|string',
			'categories.0' => 'exists:groom_tip_categories,id',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {

			$new_groomtips = GroomTips::find($request->groomtips_id);
			$new_groomtips->name = $request->name;
			$new_groomtips->description = $request->description;
			$new_groomtips->category_id = $request->categories[0];
			$new_groomtips->user_id = $user_id;
			$new_groomtips->status = "APPROVED";
			$new_groomtips->save();

			//Pictures
			if (!empty($request->pictures)) {
				$url = array();

				//First Picture width 250px
				$first_picture = $request->pictures[0];
				$filename = time() . '_' . uniqid() . '.' . $first_picture->getClientOriginalExtension();

				// Load and resize to 250px
				$img = Image::make($first_picture);
				$img->resize(250, null, function ($constraint) {
					$constraint->aspectRatio();
				});

				// Save to public/storage/groomtips folder
				$small_path = 'groomtips/small_' . $filename;
				$img->save(public_path('storage/' . $small_path), 100);

				// Get URL for the small image
				$url[] = '/storage/' . $small_path;

				//Second Picture width 600px
				$img = Image::make($first_picture);

				if ($img->width() > 600) {
					$img->resize(600, null, function ($constraint) {
						$constraint->aspectRatio();
					});
				}

				// Save to public/storage/groomtips folder
				$medium_path = 'groomtips/medium_' . $filename;
				$img->save(public_path('storage/' . $medium_path), 100);

				// Get URL for the medium image
				$url[] = '/storage/' . $medium_path;

				$pictures = GroomTipsPicture::where('groom_tips_id', $request->groomtips_id)->get();

				$i = 0;
				foreach ($pictures as $picture) {
					$pic = GroomTipsPicture::find($picture['id']);

					if (!empty($pic->id) && $i < 2) {
						// Delete old file from disk
						$old_file_path = public_path(parse_url($pic->url, PHP_URL_PATH));
						if (file_exists($old_file_path)) {
							unlink($old_file_path);
						}

						$pic->url = $url[$i];
						$pic->save();
					}

					$i++;
				}
			}

			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.groomingtips');
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
			'groomtip_id' => 'required|exists:groom_tips,id',
		], $messages, $customAttributes);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {

			$new_groomtips = GroomTips::find($request->groomtip_id);
			$new_groomtips->delete();

			$pictures = GroomTipsPicture::where('groom_tips_id', $request->groomtip_id)->get();

			foreach ($pictures as $picture) {
				$pic = GroomTipsPicture::find($picture['id']);

				if (!empty($pic->id)) {
					// Delete file from local disk
					$file_path = public_path(parse_url($pic->url, PHP_URL_PATH));
					if (file_exists($file_path)) {
						unlink($file_path);
					}

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

	public function groomtips_slug_maker($name)
	{
		$name = $this->slug_format($name);
		$slugs = GroomTips::where('slug', $name)->get();

		return $name . "_" . ($slugs->count() + rand(1, 9000));
	}

	public function categories()
	{
		$categories = GroomTipCategory::all();
		return view('admin.grooming_tips.category.index', ['categories' => $categories]);
	}

	public function category_create()
	{
		return view('admin.grooming_tips.category.create');
	}

	public function category_edit($id)
	{
		$category = GroomTipCategory::find($id);

		if (empty($category->id)) {
			return back()->withErrors(['Category does not exist']);
		} else {
			$page_title = "Edit Category";
			$update_url = route('admin.groomingtip.category.update');
			return view('admin.grooming_tips.category.edit', ['page_title' => $page_title, 'data' => $category, 'update_url' => $update_url]);
		}
	}

	public function category_add(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'names' => 'required',
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$categories = explode(",", $request->names);
			foreach ($categories as $category) {
				$new_category = new GroomTipCategory;
				$new_category->name = $category;
				$new_category->user_id = Auth::id();
				$new_category->save();
			}

			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.groomingtip.categories');
		}
	}

	public function category_update(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => 'required|exists:groom_tip_categories,id',
			'name' => 'required',
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$category = GroomTipCategory::find($request->id);
			$category->name = $request->name;
			$category->user_id = Auth::id();
			$category->save();

			session()->flash('message', 'Task was successful!');
			return redirect()->route('admin.groomingtip.categories');
		}
	}
}
