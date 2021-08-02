@extends('layouts.admin')
@section('title', 'Create Page')
@section('page.title', 'Create Page')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Page
			<a class="btn btn-sm warm-blue-bg float-right" href="{{route('admin.pages')}}">back to pages</a>
		</h3>
	</div>
	<div class="col-12">
		<form method="post" action="{{route('admin.pages.save')}}"  enctype="multipart/form-data" >
			@csrf
			<input type="hidden" name="type" value="{{$type}}"/>
			<input type="hidden" name="page_id" value="{{$page->id ?? '' }}"/>
<!--
			<input type="hidden" name="old_picture" value="{{$page->picture ?? '' }}"/>
-->
			<div class="row">
				<div class="col-md-9 col-sm-12 mt-2">
					<div class="form-group">
						<label for="name">Title</label>
						<input type="text" name="name" class="form-control" id="name" value="{{$page->name ?? old('name') }}" aria-describedby="nameHelp" required />
		<!--
						<small id="nameHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
		-->
						@error('name')
							<small id="nameHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
					
					<div class="form-group">
						<label for="slug">Slug</label>
						<input type="text" name="slug" class="form-control" id="slug" value="{{$page->slug ?? old('slug') }}" aria-describedby="slugHelp" required />
						<small id="slugHelp" class="form-text text-muted">Please type in a unique url name for the page.</small>
						@error('slug')
							<small id="slugHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
					
					<div class="form-group">
						<label for="description">Description</label>
						<textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp" required >{{ $page->description ?? old('description') }}</textarea>
						<small id="descriptionHelp" class="form-text text-muted">Please write about this page.</small>
						@error('description')
							<small id="descriptionHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
					</div>
					
					
				</div>
				
				<div class="col-md-5 col-sm-12 mt-2">
					
					
				</div>
				
				<div class="col-12 pt-2" style="border-top: 2px solid #dddddd;">
					<button type="submit" class="btn main-color-bg">Save</button>
				</div>
			</div>
		</form>
		</div>
	
	
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{url('assets/css/bootstrap-datepicker3.css')}}"/>
@endpush
@push('scripts')
	<script src="{{url('assets/js/bootstrap-datepicker.js')}}" ></script>
    <script src="https://cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
    <script>
		  CKEDITOR.replace( 'description' );
		  
		  $('.datepicker').datepicker({
				format: 'yyyy-mm-dd',
			});
			
	var loadFile = function(event, image_id) {
		var image = document.getElementById(image_id);
		image.src = URL.createObjectURL(event.target.files[0]);
	};
</script>
@endpush
