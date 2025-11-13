@extends('layouts.user')
@section('title', 'Edit Notification Settings')
@section('page.title', 'Edit Notification Settings')
@section('content')
<div class="container mt-2">
	<div class="col-12">
		<h4 class="main-color my-2">Notification Settings</h4>
		<p>Please select the brands and categories you wish to receive notification on.</p>
		<form class="mt-2" method="post" action="{{route('user.notification.update')}}" >
			@csrf
			<div class="form-row m-0 p-0">
				<div class="col-md-6 col-sm-12 my-2">
					<h4>Brands</h4>
					<div class="col--12 my-2" style="height: 150px; overflow-y: scroll;">
					<input type="checkbox" name="CheckAllBrands" class="brands" onchange="checkAllBrands(this)" />Select all Brands<br>
						@foreach($listings->sortBy('name') as $listing)
						<div class="form-check">
						    
							<input class="form-check-input brands" name="brands[]" type="checkbox" value="{{$listing->id}}"  id="checkB{{$listing->id}}" {{ (in_array($listing->id, $selected['brands']) ? 'checked':'') }} />
							<label class="form-check-label" for="checkB{{$listing->id}}">
								{{$listing->name}}
							</label>
						</div>
						@endforeach
					</div> 
				</div>
				
				<div class="col-md-6 col-sm-12 my-2">
					<h4>Categories </h4>
					<div class="col--12 my-2" style="height: 150px; overflow-y: scroll;">
					<input type="checkbox" name="CheckAllCategories" class="categories" onchange="checkAllCategories(this)" />Select all Categories<br>
						@foreach($categories->where('parent_id', 0 ) as $parent_category)
						<label class="font-weight-bolder mt-4">{{$parent_category->name}}</label>
						 
							@foreach($parent_category->subcategories as $category)
								<div class="form-check">
								
									<input class="form-check-input categories" name="categories[]" type="checkbox" value="{{$category->id}}" id="checkC{{$category->id}}" {{ (in_array($category->id, $selected['categories']) ? 'checked':'') }}  />
									<label class="form-check-label" for="checkC{{$category->id}}">
										{{$category->name}}
									</label>
								</div>
								@endforeach
						@endforeach
					</div>
				</div>
				
				<div class="col-12 p-2" style="border-top: 2px solid #dddddd;">
					<h4>Preferences</h4>
					<div class="col--12 my-2 p-0">
						@foreach($days as $day)
							<div class="form-check d-block d-lg-inline m-sm-0 m-md-2">
								<input class="form-check-input" type="checkbox" name="preferred_days[]" value="{{$day}}" id="check{{$day}}" {{ (in_array($day, $selected['days']) ? 'checked' : '' ) }} />
								<label class="form-check-label" for="check{{$day}}">{{$day}}</label>
							</div>
						@endforeach
					</div>
				</div>
				<div class="col-12 pt-2" style="border-top: 2px solid #dddddd;">
					<button type="submit" class="btn main-btn-bg">Save</button>
				</div>
			</div>
		
		</form>

		</div>
	
	
</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
		  CKEDITOR.replace( 'description' );
		  
	var loadFile = function(event, image_id) {
		var image = document.getElementById(image_id);
		image.src = URL.createObjectURL(event.target.files[0]);
	}; 
	
	function checkAllBrands(checkbox) {
        var checkboxes = document.querySelectorAll('.brands');
        checkboxes.forEach(function (box) {
            box.checked = checkbox.checked;
        });
    }

    function checkAllCategories(checkbox) {
        var checkboxes = document.querySelectorAll('.categories');
        checkboxes.forEach(function (box) {
            box.checked = checkbox.checked;
        });
    }
</script>
@endpush
