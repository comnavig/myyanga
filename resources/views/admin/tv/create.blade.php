@extends('layouts.admin')
@section('title', 'New Tv')
@section('page.title', 'Add New Tv')
@section('content')
<div class="container mt-2">
	
	<form method="post" action="{{route('admin.tv.add')}}" enctype="multipart/form-data">
		<div class="col-lg-5 col-sm-12 mt-2">
		@csrf
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" aria-describedby="nameHelp">
<!--
			<small id="nameHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
-->
			@error('name')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror
			
		</div>
		
		<div class="form-group">
			<label for="youtube">Youtube Video URL</label>
			<input type="text" name="youtube" class="form-control" id="youtube" value="{{ old('youtube') }}" aria-describedby="youtubeHelp">
<!--
			<small id="youtubeHelp" class="form-text text-muted">We'll never share your youtube with anyone else.</small>
-->
			@error('youtube')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
		
		@for ($i = 0; $i < 1; $i++)
			<div class="form-group">
				<label for="categories[{{$i}}]">Category </label>
				<select name="categories[{{$i}}]" class="form-control" id="categories[{{$i}}]" aria-describedby="categoriesHelp" required >
					<option value="">Please Select Category</option>
					@foreach($categories as $category)
						<option value="{{$category->id}}" {{ (old('categories.'.$i) == $category->id ? "selected" : "" )}}>{{$category->name}}</option>
					@endforeach	
				</select>
				<!--
				<small id="catgeoriesHelp" class="form-text text-muted">We'll never share your catgeories with anyone else.</small>
				-->
				@error('categories.'.$i)
					<small id="catgeoriesHelp" class="form-text text-muted red">{{ $message }}</small>
				@enderror
				
			</div>
		@endfor
		</div>	
		<div class="col-md-12 col-sm-12 mt-2">
			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp" rows="12" required >{{ old('description') }}</textarea>
				@error('description')
					<small id="descriptionHelp" class="form-text text-muted red">{{ $message }}</small>
				@enderror
			</div>
		
		</div>	
		
		
		<button type="submit" class="btn main-color-bg">Add</button>
	</form>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{url('assets/css/bootstrap-datepicker3.css')}}"/>
@endpush
@push('scripts')
    <script src="{{url('assets/js/bootstrap-datepicker.js')}}" ></script>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
		  CKEDITOR.replace( 'description' );
		  
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
		});
    </script>
@endpush
