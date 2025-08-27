@extends('layouts.admin')
@section('title', 'Edit '.$settings->name)
@section('page.title', 'Edit '.$settings->name)
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Form
			<a class="btn btn-sm main-btn-bg float-right" href="{{route('admin.settings')}}">back to settings</a>
		</h3>
	</div>
	<div class="col-12">
		<form method="post" action="{{route('admin.settings.update')}}"  enctype="multipart/form-data" >
			@csrf
			<input type="hidden" name="settings_id" value="{{$settings->id}}" />
			<div class="row">
				<div class="col-md-12 col-sm-12 mt-2">
					<div class="form-group">
						<label for="value">Value</label>
						<input type="text" name="value" class="form-control" id="value" value="{{$settings->value}}" aria-describedby="valueHelp" required />
		<!--
						<small id="valueHelp" class="form-text text-muted">We'll never share your value with anyone else.</small>
		-->
						@error('value')
							<small id="valueHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
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
</script>
@endpush
